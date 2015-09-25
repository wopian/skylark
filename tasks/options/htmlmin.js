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
            'dist/index.php': 'src/index.php'
        }
    }
}
