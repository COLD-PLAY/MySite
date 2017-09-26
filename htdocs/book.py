from flask import Flask
import pymongo

connection = pymongo.MongoClient('127.0.0.1',27017)
kinds = ['文学', '流行', '文化', '生活', '经管', '科技']

app = Flask(__name__)

@app.route('/index')
def index():
	count = 0

	all_collections = {}

	for kind in kinds:
		db = connection[kind]
		collections = db.collection_names()

		all_collections[kind] = collections
		
	return str(all_collections)


	# db = connection['文化']
	# collection = db['中国历史']

	# posts = collection.find()
	# i = 0
	# for post in posts:
	# 	if i > 10: break

	# 	print(type(post))

	# 	i += 1

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=20480)