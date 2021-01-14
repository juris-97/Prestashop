import time

from selenium import webdriver
import random
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common import action_chains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By

driver = webdriver.Firefox(executable_path="./selenium-firefox/drivers/geckodriver")
#driver.set_window_size(1000, 700)
driver.get("https://localhost/prestashop/index.php")

# MACRO
#1
driver.find_element(By.CSS_SELECTOR,".sf-menu > li:nth-child(4) > a:nth-child(1)").click()


driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(7) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()
#2
driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(5) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()
#3
driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(6) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()
#4
driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(3) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()
#5
driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(12) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()

# CATEGORY KRAJOBRAZ
#1
driver.find_element(By.CSS_SELECTOR,".sf-with-ul").click()
driver.find_element(By.CSS_SELECTOR,"#subcategories > ul:nth-child(2) > li:nth-child(2) > h5:nth-child(2) > a:nth-child(1)").click()

driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(7) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()
#2
driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(5) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()
#3
driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(6) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()
#4
driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(3) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()
#5
driver.find_element(By.CSS_SELECTOR,"li.ajax_block_product:nth-child(12) > div:nth-child(1) > div:nth-child(2) > h5:nth-child(1) > a:nth-child(1)").click()

for _ in range(0,random.randint(0,5)):
    driver.find_element(By.CSS_SELECTOR, ".icon-plus").click()
driver.find_element(By.CSS_SELECTOR,"button.exclusive").click()
wait = WebDriverWait(driver, 10)
element = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,".continue > span:nth-child(1)")))

driver.back()

driver.find_element(By.CSS_SELECTOR, ".shopping_cart > a:nth-child(1)").click()
driver.find_element(By.CSS_SELECTOR, ".icon-trash").click()
time.sleep(2)
driver.find_element(By.CSS_SELECTOR, ".standard-checkout > span:nth-child(1)").click()
driver.find_element(By.CSS_SELECTOR, "#email_create").send_keys("agata123@gmail.com")
driver.find_element(By.CSS_SELECTOR, "#SubmitCreate > span:nth-child(1)").click()
time.sleep(2)
driver.find_element(By.CSS_SELECTOR, "div.radio-inline:nth-child(4) > label:nth-child(1)").click()
driver.find_element(By.CSS_SELECTOR, "#customer_firstname").send_keys("Agata")
driver.find_element(By.CSS_SELECTOR, "#customer_lastname").send_keys("Kowalska")
driver.find_element(By.CSS_SELECTOR, "#passwd").send_keys("12345")
driver.find_element(By.CSS_SELECTOR, "#submitAccount > span:nth-child(1)").click()


driver.find_element(By.CSS_SELECTOR, "#address1").send_keys("Traugutta 115")
driver.find_element(By.CSS_SELECTOR, "#postcode").send_keys("80-226")
driver.find_element(By.CSS_SELECTOR, "#city").send_keys("Gdynia")
driver.find_element(By.CSS_SELECTOR, "#phone").send_keys("+48321223486")
driver.find_element(By.CSS_SELECTOR, "#phone_mobile").send_keys("+48730227886")
driver.find_element(By.CSS_SELECTOR, "#alias").send_keys("adr")
driver.find_element(By.CSS_SELECTOR, "#submitAddress > span:nth-child(1)").click()

driver.find_element(By.CSS_SELECTOR, "button.button:nth-child(4) > span:nth-child(1)").click()

time.sleep(2)
# driver.find_element(By.CSS_SELECTOR, "#uniform-delivery_option_14_1").click()
driver.find_element_by_xpath("/html/body/div/div[2]/div/div[3]/div/div/form/div/div[2]/div[1]/div[2]/div/table/tbody/tr/td[1]/div/span").click()
driver.find_element(By.CSS_SELECTOR, "#cgv").click()
driver.find_element(By.CSS_SELECTOR, "button.button:nth-child(4) > span:nth-child(1)").click()

driver.find_element(By.CSS_SELECTOR, ".cash").click()
driver.find_element(By.CSS_SELECTOR, "button.button-medium > span:nth-child(1)").click()

driver.find_element(By.CSS_SELECTOR, ".account > span:nth-child(1)").click()
driver.find_element(By.CSS_SELECTOR, ".myaccount-link-list > li:nth-child(1) > a:nth-child(1) > span:nth-child(2)").click()
driver.find_element(By.CSS_SELECTOR, ".history_detail > a:nth-child(1) > span:nth-child(1)").click()


# driver.close()

