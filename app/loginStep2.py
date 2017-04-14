#!/usr/bin/python3
import sys
import os
import getpass
import requests
from bs4 import BeautifulSoup
import urllib.request
import pymysql
from time import gmtime, strftime



time=strftime("%Y-%m-%d %H:%M:%S", gmtime())
url ="http://jeton.araku.ac.ir"

user_id=sys.argv[1]
captcha=sys.argv[2]



db = pymysql.connect(host="localhost",user="mghinfo_root",passwd="ER(a<sTQ6LbA(M-M",db="mghinfo_blog",charset="utf8")
cursor = db.cursor()

selecttSql="SELECT VIEWSTATE,VIEWSTATEGENERATOR,EVENTVALIDATION FROM JUserView where user_id=%s"
try:
	cursor.execute(selecttSql,(user_id))
	result=cursor.fetchone()
except BaseException as e:
	print("if Error"+str(e))
finally:
	db.close()

VIEWSTATE=result[0]
VIEWSTATEGENERATOR=result[1]
EVENTVALIDATION=result[2]

s=requests.session()
r=s.post(url+"/login.aspx",data={'__LASTFOCUS':'' ,'__EVENTTARGET':'','__EVENTARGUMENT':'',
                                        '__VIEWSTATE':VIEWSTATE,'__VIEWSTATEGENERATOR':VIEWSTATEGENERATOR,
                                        '__VIEWSTATEENCRYPTED':'','__EVENTVALIDATION':EVENTVALIDATION,
                                        'txtusername':11521,'txtpassword':9213231259,
                                        'CaptchaControl1':captcha,'btnlogin':'ورود'})


html_doc=r.text
soup = BeautifulSoup(html_doc, 'html.parser')

etebar=soup.find(id="lbEtebar").text
# print(r.text.encode('utf-8'))
# with open("/home/mghinfo/name.txt", "w+") as text_file:
#     print(name.encode('utf8'), file=text_file)



# print(os.getegid())
# print(os.geteuid())
print("Success")
# name=name.encode('utf-8')
# name=name.decode('utf-8')
# print(sys.getdefaultencoding())

name=soup.find(id="LbFName").text
# name ="u "+name.decode()
# print(type(name))
# name_encoded=name.encode('utf-8')
# name_decoded=name_encoded.decode('utf-8')
# print(type(name))
print(name.encode('utf-8'))
# sys.stdout.buffer.write(name.encode("utf-8"))

# print(u"{}".format(name))

print(etebar)