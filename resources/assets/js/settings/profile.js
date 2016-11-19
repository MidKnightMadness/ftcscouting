Vue.component('settings-security', {
        data(){
            return {
                forms: {
                    changePassword: $.extend(true, new Form({
                            current_password: '',
                            password: '',
                            password_confirmation: ''
                        }
                    ), {})
                }
            }
        },
        methods: {
            savePassword(){
                Scouting.post('/profile/changePassword', this.forms.changePassword).catch(e=> {
                    // Ignore errors
                });
            }
        }

    }
);
Vue.component('settings-profile', {
    data(){
        return {
            forms: {
                userData: $.extend(true, new Form({
                        email: '',
                        name: '',
                    }
                ), {})
            },
        }
    },

    mounted(){
        var vm = this;
        this.eventHub.$on('userRetrieved', function (user) {
            this.forms.userData.email = user.email;
            this.forms.userData.name = user.name;
        }.bind(vm));
    },

    methods: {
        updateProfile(){
            Scouting.post('/profile/update', this.forms.userData).catch(e=>{
                // Ignore
            });
        }
    }
});