export default () => ({
    loading: false, $wire: undefined,

    generateReport() {
        this.loading = true

        const sizes = this.$refs.vegalitecontainer.getBoundingClientRect()

        this.$wire.generateReport()
            .then((result) => {
                const dataset = this.$wire.get('dataset');

                result.data = dataset
                result.height = sizes.height
                result.width = sizes.with

                console.log(dataset, result, sizes)

                window.vegaEmbed('#vis', result)
            })
    }
})
