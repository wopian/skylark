module.exports = {
    dist: {
        options: {
            removeComments: true,
            collapseWhitespace: true
        },
        files: {
            'app/index.php': 'dev/index.php',
            'app/slack.php': 'dev/slack.php'
        }
    }
}
