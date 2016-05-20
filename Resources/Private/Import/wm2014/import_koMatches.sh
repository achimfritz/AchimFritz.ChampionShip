#!/bin/bash

if [ -z "$HTTP_HOST" ]; then
	exit "HTTP_HOST not set"
fi


cat koMatches.json|while read i; do
   curl -X PUT  -H "Accept:application/json" "http://$HTTP_HOST/achimfritz.championship.import/komatch/index" -d "$i" -H "Content-Type:application/json"
	echo ""
done
