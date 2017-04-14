import requests
from bs4 import BeautifulSoup
import urllib.request

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

urllib.request.urlretrieve(captcha,"captcha.jpg")   #saving image into filename captcha


captcha=input('Please Insert Captcha:')

r=s.post(url+"/login.aspx",data={'__LASTFOCUS':'' ,'__EVENTTARGET':'','__EVENTARGUMENT':'',
                                        '__VIEWSTATE':VIEWSTATE,'__VIEWSTATEGENERATOR':VIEWSTATEGENERATOR,
                                        '__VIEWSTATEENCRYPTED':'','__EVENTVALIDATION':EVENTVALIDATION,
                                        'txtusername':11521,'txtpassword':9213231259,
                                        'CaptchaControl1':captcha,'btnlogin':'ورود'})

html_doc=r.text
soup = BeautifulSoup(html_doc, 'html.parser')
etebar=soup.find(id="lbEtebar").text
print(etebar)