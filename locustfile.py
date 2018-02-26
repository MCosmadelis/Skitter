from locust import HttpLocust, TaskSet, task

class UserBehavior(TaskSet):
    def on_start(self):
        """ run before any other task"""
        self.get_index()

    @task(1)
    def get_index(self):
        """ make a get request """
        self.client.get('/')

class WebsiteUser(HttpLocust):
    task_set = UserBehavior
    host = 'http://localhost'
