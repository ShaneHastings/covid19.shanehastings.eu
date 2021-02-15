# ECDC Vaccine Distribution
# Using Selenium and Chromedriver to scrape a dynamically updated website.

import requests 
from bs4 import BeautifulSoup 
from selenium import webdriver 
from selenium.webdriver.common.keys import Keys 
import time

## Define Selenium location
path = r'C:\Users\Hasti\Chromedriver\chromedriver.exe'
driver = webdriver.Chrome(executable_path = path)

## Dynamic webpage we want to grab data from (ECDC Vaccine Tracker Page)
driver.get('https://qap.ecdc.europa.eu/public/extensions/COVID-19/COVID-19.html#vaccine-tracker-tab')

## Wait for page to load in data
time.sleep(9)
html = driver.page_source


## Parse generated HTML and find the element containing Vaccine Distribution info.
soup = BeautifulSoup(html, "html.parser")
all_divs = soup.find('div', {'id' : 'widgetnFZTZ'})
vaccineData = all_divs.findAll('td')

# Printing the contents of the last table <td> element, as this holds the value we want.
for data in vaccineData[-1] : 
    print(data)
    # It gets saved with a lot of white space so we'll remove this with variable.strip()
    vaccinesDistributed = data.strip()
  
driver.close()


# Writing this to a txt file. 
vaxFile = open("vaccinationsDistributed.txt", "w")
vaxFile.write(vaccinesDistributed)
vaxFile.close()
print("Successfully written " + vaccinesDistributed + " as number of vaccines distributed to EU/Norway/Iceland so far.")
