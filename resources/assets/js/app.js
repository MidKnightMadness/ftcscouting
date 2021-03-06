/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('textarea-charcount', require('./components/TextAreaCharCount.vue'));
Vue.component('alert', require('./components/Alert.vue'));
Vue.component('team-manage-members', require('./components/team/ManageMembers.vue'));
Vue.component('team-manage-roles', require('./components/team/ManageRoles.vue'));
Vue.component('team-manage-surveys', require('./components/team/ManageSurvey.vue'));
Vue.component('edit-survey', require('./components/survey/EditSurvey.vue'));
Vue.component('survey-responses', require('./components/survey/Responses.vue'));
Vue.component('toggle', require('./components/Toggle.vue'));

Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));

/**
 * Load the form bootstrapper
 */
require('./form/bootstrapper');
require('./settings/bootstrapper');
const eventHub = new Vue();
Vue.mixin({
    data: function(){
        return {
            eventHub: eventHub
    }
    }
});
const app = new Vue({
    el: '#app',

    mounted: function(){
        if (window.Scouting.user != 'null')
            axios.get('/api/user').then(resp=> {
                window.Scouting.user = resp.data;
                this.eventHub.$emit('userRetrieved', resp.data);
            })
    }
});
