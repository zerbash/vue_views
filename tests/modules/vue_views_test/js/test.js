const TestApp = {
    data() {
        return {
            rows: {}
        }
    },
    created: function() {
        this.rows = drupalSettings.vue_views_data
    }
}

Vue.createApp(TestApp).mount('#vue-views-app')
