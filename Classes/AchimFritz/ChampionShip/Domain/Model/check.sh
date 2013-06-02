#!/bin/bash

grep AchimFritz *.php |grep -v '\\AchimFritz'|grep -v script|grep -v namespace
grep 'AchimFritz\\ChampionShip\\Domain\\Model\\Achim' *.php
