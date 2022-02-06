# Symfony based Client class
## Client class has 4 parameters which include:
### 1.HttpClientInterface taken from Sympony. 
### 2.string $url which is used to base a connection to an outside service
### 3.string $geturl which is concatinated to a $url to base a connection to a get handle
### 4.string $posturl which is concatinated to a $url to base a connection to a post and put handles, as it is stated in a task
## Client class has 2 set methods for $geturl and $posturl, also during construction of said class base $url is set, same goes for an instance of HttpClientInterface
## Client class has 3 functions to preform get, post and put requests.
# PhpUnit tests
## Located in ClientTests file, these unit tests provide a test per Client's get, post and put methods.
## All of the tests are successul, and as such it is save to assume that Client is in working order
