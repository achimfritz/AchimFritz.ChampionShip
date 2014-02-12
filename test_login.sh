#!/bin/bash

#curl -v -XGET --header "Authorization: Basic YWRtaW46dGVzdDEyMw==" http://api/
#curl -v -XGET --header "Authorization: Basic YWRtaW46dGVzdDEyMw==" http://api/index.php/achimfritz.championship/TestLogin
curl -XPOST --header "Authorization: Basic YWRtaW46dGVzdDEyMw==" http://api/index.php/achimfritz.championship/TestLogin

#echo "admin:test123"|base64 no no no

#php echo base64_encode('admin:test123');
