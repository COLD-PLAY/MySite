from flask import Flask, request

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By

import json, re

app = Flask(__name__)

SERVICE_ARGS = ['--load-images=false', '--disk-cache=true']

def parseKb(kb):
	kb_ = []
	for i in range(12):
		kb_.append([])
		for j in range(7):
			kb_[i].append('')

	for i in range(7):
		has = 0
		for j in range(5):
			if kb[j][i][1]:
				for k in range(int(kb[j][i][1])):
					kb_[has][i] = kb[j][i][0].replace('\n', '')
					has += 1
			else: has += 2
	kb_dict = {}
	for i in range(12):
		kb_dict["l" + str(i)] = kb_[i][:]

	return kb_dict

def spide_kb(username, password):
	# driver = webdriver.Chrome()
	driver = webdriver.PhantomJS(service_args=SERVICE_ARGS)
	# driver.set_window_size(1400, 900)
	wait = WebDriverWait(driver, 10)
	driver.get('http://eams.uestc.edu.cn/eams/home!childmenus.action?menu.id=844')

	# sid = str(input('请输入学号: '))
	# pw = str(input('请输入密码: '))

	sid = username
	pw = password

	try:
		username = wait.until(
			EC.presence_of_element_located((By.CSS_SELECTOR, '#username'))
		)
		password = wait.until(
			EC.presence_of_element_located((By.CSS_SELECTOR, '#password'))
		)

		username.send_keys(sid)
		password.send_keys(pw)
		password.send_keys(Keys.RETURN)

		try:
			djcc = driver.find_element_by_link_text('点击此处')
			djcc.click()
			wdkb = wait.until(
				EC.presence_of_element_located((By.CSS_SELECTOR, '#MLeft > div > table.list_1 > tbody > tr:nth-child(5) > td:nth-child(7) > div:nth-child(3) > a'))
			)
		except Exception:
			wdkb = wait.until(
				EC.presence_of_element_located((By.CSS_SELECTOR, '#MLeft > div > table.list_1 > tbody > tr:nth-child(7) > td:nth-child(1) > div:nth-child(3) > a'))
			)
		wdkb.click()

		table = wait.until(
				EC.presence_of_element_located((By.CSS_SELECTOR, '#manualArrangeCourseTable > tbody'))
			)

		trs = table.find_elements_by_tag_name('tr')
		kb = []

		for i in range(len(trs)):
			if i % 2 == 0 and i <= 8:
				tds = trs[i].find_elements_by_tag_name('td')

				line = []
				for td in tds[1:]:
					line.append([td.text, td.get_attribute('rowspan')])

				# 补全
				if len(line) != 7:
					for i in range(len(line), 7):
						line.append(['', ''])

				kb.append(line)

		# kb is 12*7's array for all lessones
		# kb_dict is the dict of kb
		kb_dict = parseKb(kb)
		
		driver.quit()
		return kb_dict
	except Exception as e:
		driver.quit()
		print('Something Goes Wrong!!!: ' + e)

@app.route('/kb')
def main_kb():
	# username = '2015060103012'
	# password = '101387'

	username = request.args.get('username')
	password = request.args.get('password')

	kb_dict = spide_kb(username, password)

	pattern = re.compile(".*? (.*?)\(.*?,(.*?)\)")

	for i in range(12):
		lessones = []
		for lesson in kb_dict["l" + str(i)]:
			if lesson == "":
				lessones.append(lesson)
			else:
				items = list(re.findall(pattern, lesson)[0])

				if len(items[0]) >= 8:
					items[0] = items[0][0:8] + '...'

				lessones.append('\n'.join(items))
		kb_dict["l" + str(i)] = lessones

	kb_json = json.dumps(kb_dict, ensure_ascii=False)

	return '_____' + kb_json

def spide_cj(username, password):
	url = 'http://eams.uestc.edu.cn/eams/teach/grade/course/person!historyCourseGrade.action?projectType=MAJOR'
	# driver = webdriver.Chrome()
	driver = webdriver.PhantomJS()
	wait = WebDriverWait(driver, 10)

	driver.get(url)

	sid = username
	pw = password

	try:
		# print('startings...')

		username = wait.until(
			EC.presence_of_element_located((By.CSS_SELECTOR, '#username'))
		)
		password = wait.until(
			EC.presence_of_element_located((By.CSS_SELECTOR, '#password'))
		)
		# print('logining...')

		username.send_keys(sid)
		password.send_keys(pw)
		password.send_keys(Keys.RETURN)

		try:
			djcc = driver.find_element_by_link_text('点击此处')
			djcc.click()

		except Exception as e:
			pass

		# print('parsing...')

		term_table = driver.find_element_by_css_selector('body > table')
		detail_table = driver.find_element_by_css_selector('body > div.grid')

		# print(term_table, detail_table)

		term_trs = term_table.find_elements_by_tag_name('tr')
		detail_trs = detail_table.find_elements_by_tag_name('tr')

		term_ths = term_trs[0].find_elements_by_tag_name('th')
		term_ths = [th.text for th in term_ths]

		term_tds = []
		for i in range(1, len(term_trs)):
			tds = term_trs[i].find_elements_by_tag_name('td')
			term_tds.append([td.text for td in tds])

		detail_ths = detail_trs[0].find_elements_by_tag_name('th')
		detail_ths = [detail_ths[i].text for i in [0, 3, 4, 5, 6, 7, 8]]

		detail_tds = []
		for i in range(1, len(detail_trs)):
			tds = detail_trs[i].find_elements_by_tag_name('td')
			detail_tds.append([tds[i].text for i in [0, 3, 4, 5, 6, 7, 8]])

		# print(term_tds, detail_tds)

		# print(term_ths, detail_ths)

		cj_dict = {}
		cj_dict['term_tds'] = term_tds
		cj_dict['term_ths'] = term_ths

		cj_dict['detail_tds'] = detail_tds
		cj_dict['detail_ths'] = detail_ths

		cj_json = json.dumps(cj_dict, ensure_ascii=False)

		driver.quit()
		return cj_json

	except Exception as e:
		driver.quit()
		print(e)

@app.route('/cj')
def main_cj():
	# username = '2015060103012'
	# password = '101387'

	username = request.args.get('username')
	password = request.args.get('password')

	cj_json = spide_cj(username, password)

	return '_____' + cj_json

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=20480)