

# sh '/shared-paul-files/Webs/git-repos/Gebruiker-Centraal---plugin-voor-plugin-correcties/distribute.sh' &>/dev/null

# clear the log file
> '/shared-paul-files/Webs/ICTU/Gebruiker Centraal/development/wp-content/debug.log'

# copy to temp dir
rsync -r -a --delete '/shared-paul-files/Webs/git-repos/Gebruiker-Centraal---plugin-voor-plugin-correcties/' '/shared-paul-files/Webs/temp/'

# clean up temp dir
rm -rf '/shared-paul-files/Webs/temp/.git/'
rm '/shared-paul-files/Webs/temp/.gitignore'
rm '/shared-paul-files/Webs/temp/LICENSE'
rm '/shared-paul-files/Webs/temp/.codekit-cache'
rm '/shared-paul-files/Webs/temp/config.codekit3'
rm '/shared-paul-files/Webs/temp/distribute.sh'
rm '/shared-paul-files/Webs/temp/README.md'
rm '/shared-paul-files/Webs/temp/README.html'

cd '/shared-paul-files/Webs/temp/'
find . -name ‘*.DS_Store’ -type f -delete

/shared-paul-files/Webs/ICTU/Gebruiker Centraal/sentia/accept/www/wp-content/plugins/gebruiker-centraal-add-on/


# copy from temp dir to dev-env
rsync -r -a --delete '/shared-paul-files/Webs/temp/' '/shared-paul-files/Webs/ICTU/Gebruiker Centraal/development/wp-content/plugins/gebruiker-centraal-add-on/' 

# remove temp dir
rm -rf '/shared-paul-files/Webs/temp/'



# Naar Eriks server
rsync -r -a  --delete '/shared-paul-files/Webs/ICTU/Gebruiker Centraal/development/wp-content/plugins/gebruiker-centraal-add-on/' '/shared-paul-files/Webs/ICTU/Gebruiker Centraal/live-dutchlogic/wp-content/plugins/gebruiker-centraal-add-on/'

# en een kopietje naar Sentia accept
rsync -r -a --delete '/shared-paul-files/Webs/ICTU/Gebruiker Centraal/development/wp-content/plugins/gebruiker-centraal-add-on/' '/shared-paul-files/Webs/ICTU/Gebruiker Centraal/sentia/accept/www/wp-content/plugins/gebruiker-centraal-add-on/'

# en een kopietje naar Sentia live
rsync -r -a --delete '/shared-paul-files/Webs/ICTU/Gebruiker Centraal/development/wp-content/plugins/gebruiker-centraal-add-on/' '/shared-paul-files/Webs/ICTU/Gebruiker Centraal/sentia/live/www/wp-content/plugins/gebruiker-centraal-add-on/'

