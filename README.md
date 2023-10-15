mvc-repo
==================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Bruffe/mvc-repo/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/Bruffe/mvc-repo/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/Bruffe/mvc-repo/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/Bruffe/mvc-repo/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/Bruffe/mvc-repo/badges/build.png?b=main)](https://scrutinizer-ci.com/g/Bruffe/mvc-repo/build-status/main)

### Description
This is my repo for the [mvc course](https://dbwebb.se/kurser/mvc-v2). The latest versions (10.0.0 and newer) are dedicated to the last assignment in the mvc course. In that assignment I had to choose what type of game I wanted to implement on the website, with options like Blackjack, Solitaire and other games. I chose to do Blackjack. You can play the game against the dealer in the browser. You choose if you want to play with 1, 2 or 3 hands and you can bet fake money called Schilling.

### Installation steps for Ubuntu Terminal:
1. Clone the repository with HTTPS or SSH
    - `git clone https://github.com/Bruffe/mvc-repo.git` HTTPS
    - `git clone git@github.com:Bruffe/mvc-repo.git` SSH
2. `composer install` Install PHP packages defined in composer.json
3. `npm install` Install JavaScript packages defined in package.json
4. `php -S localhost:8888 -t public/` Start the website
5. Open up localhost:8888 in your preferred browser
