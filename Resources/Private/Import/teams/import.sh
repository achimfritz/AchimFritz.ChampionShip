#!/bin/bash

if [ -z "$HTTP_HOST" ]; then
	exit "HTTP_HOST not set"
fi

cat teams.json|while read i; do
   curl -X PUT  -H "Accept:application/json" "http://$HTTP_HOST/achimfritz.championship.import/team/index" -d "$i" -H "Content-Type:application/json"
	echo ""
done
