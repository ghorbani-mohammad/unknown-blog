#!/usr/bin/python3
import sys
import requests
from bs4 import BeautifulSoup
import urllib.request
import pymysql
from time import gmtime, strftime

time=strftime("%Y-%m-%d %H:%M:%S", gmtime())
user_id=sys.argv[1]

# print(time)

url ="http://jeton.araku.ac.ir"
urlReserve=url+"/Reserve.aspx"
urlSelect=url+"/SelectGhaza.aspx?date="
s=requests.session()
r=s.get(url)

html_doc=r.text
soup = BeautifulSoup(html_doc, 'html.parser')

VIEWSTATE=soup.find(id="__VIEWSTATE").get('value')
VIEWSTATEGENERATOR=soup.find(id="__VIEWSTATEGENERATOR").get('value')
EVENTVALIDATION=soup.find(id="__EVENTVALIDATION").get('value')

captcha=url+'/'+soup.find_all('img')[1].get('src')


db = pymysql.connect(host="localhost",user="mghinfo_root",passwd="ER(a<sTQ6LbA(M-M",db="mghinfo_blog",charset="utf8")
cursor = db.cursor()

countSql="SELECT COUNT(*) from JUserView where user_id=%s"
cursor.execute(countSql,(user_id))
result=cursor.fetchone()

if(result[0]==0):
	sql = "INSERT INTO JUserView (user_id, VIEWSTATE, VIEWSTATEGENERATOR, EVENTVALIDATION,created_at)"  
	sql+=" VALUES (%s, %s, %s, %s,%s)"
	try:
		cursor.execute(sql, (user_id,VIEWSTATE,VIEWSTATEGENERATOR,EVENTVALIDATION,time))
		db.commit()
		print("Success")
		print(captcha)
	except BaseException as e:
	    print("if Error"+str(e))
	finally:
		db.close()
else:
	sql = "UPDATE JUserView SET VIEWSTATE=%s, VIEWSTATEGENERATOR=%s,EVENTVALIDATION=%s,"
	sql+="created_at=%s WHERE user_id=%s "  
	try:
		cursor.execute(sql, (VIEWSTATE,VIEWSTATEGENERATOR,EVENTVALIDATION,time,user_id))
		db.commit()
		print("Success")
		print(captcha)
	except BaseException as e:
	    print("else Error"+str(e))
	finally:
		db.close()




