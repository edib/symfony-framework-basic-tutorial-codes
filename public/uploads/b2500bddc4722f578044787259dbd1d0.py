from selenium import webdriver

import sys

import time

from selenium.webdriver.support.ui import Select

#op = webdriver.ChromeOptions()
#op.add_argument('headless')

#browser = webdriver.Chrome(options=op)
browser = webdriver.Firefox()


browser.get("http://192.168.0.1/")

time.sleep(1)

username = browser.find_element_by_name("loginUsername")
password = browser.find_element_by_name("loginPassword")

username.send_keys("admin")
password.send_keys("Bir239876_")


loginButton = browser.find_element_by_id("btnLogin")

loginButton.click()

time.sleep(2)

browser.get("http://192.168.0.1/wlanAccess.asp")

time.sleep(1)

conType = Select(browser.find_element_by_xpath("//html/body/div[2]/div[3]/div[1]/form/table[1]/tbody/tr/td[2]/select"))

conType.select_by_value('1')

time.sleep(1)

select = Select(browser.find_element_by_name("MacRestrictMode"))

acKapat = sys.argv[1]

select.select_by_value(acKapat)

time.sleep(3)

loginButton = browser.find_element_by_xpath("//*[@id=\"btnApply\"]")

time.sleep(3)

browser.close()