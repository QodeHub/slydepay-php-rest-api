#!/bin/sh

deploy_document(){

	echo "Running all tests!"
	bin/ci.sh

	echo "Checking for documenters"
	# get sami if it does not exist.
	[ -e sami.phar ] && echo "Sami found\r\n" || curl -O http://get.sensiolabs.org/sami.phar | php;

	# get couscous if it does not exist.
	[ -e couscous.phar ] && echo "Couscous found\r\n" || curl -O http://couscous.io/couscous.phar | php;

	echo "Cleaning staging area\r\n";

	rm -rf staging_dir;

	echo "Generating Documentation\r\n";

	# Run the sami generator
	php sami.phar update ./sami.config.php -v;

	# Run the couscous static site generator
	php couscous.phar generate --target=./build/couscous;

	# clone the project and climb into the directory and switch to the gh-pages branch
	git clone ssh://git@github.com/QodeHub/bitgo-php-doc.git staging_dir;

	cd staging_dir;

	# Remove all files from the github pages folder
	shopt -s extglob;
	shopt -s dotglob nullglob;
	for i in `la | grep -v ".git"` ; do rm -rf $i; done;

	# Make a directory for the sami generated doc and test coverage
	mkdir -p ./api;
	mkdir -p ./coverage;
	touch .nojekyll;

	# copy all files from the couscous generated folder into the empty github-pages branch folder
	mv  -v ../build/couscous/* ./;

	# copy all files from the sami generated folder into the api folder
	mv  -v ../build/sami/* ./api/;

	# copy all files from the coverage generated folder into the coverage folder
	mv  -v ../build/coverage/* ./coverage/;

	# Add all and commit to github if deploy was enabled
	git add --all . && git add **/.* && git commit -m 'Update Documentation 📒' && git push;
}


# Check that the commits has been made
if git diff-index --quiet HEAD --; then
    if [[ "$(git push --porcelain)" == *"Done"* ]]
	then
		echo "Local changes were pushed."

		deploy_document
	fi
else
    echo "Please commit and push your changes first."
fi
