# wp-revisions-cleanup-script
Small WordPress action hook to keep a number of revisions but remove runduant thereafter

### to use wp-cli to fire script use
wp eval "do_action('cleanup_revisions');"

### in a php template simple add the action
do_action('cleanup_revisions');
