module.exports = {
    dist: {
        options: {
            removeComments: true,
            collapseWhitespace: true,
            conservativeCollapse: true,
            removeRedundantAttributes: true,
            removeEmptyAttributes: true,
            useShortDoctype: true
        },
        files: {
            'app/index.php': 'dev/index.php'
        }
    }
}
