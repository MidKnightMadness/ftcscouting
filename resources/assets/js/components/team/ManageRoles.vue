<style scoped>
    .m-t-10 {
        margin-top: 10px;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .25s
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>

<template>
    <div>
        <p class="help-text">
            Please choose a role from the list below to edit its permissions
        </p>
        <div class="col-md-4" v-for="role in roles">
            <button class="btn btn-default form-control m-t-10" @click="editRole(role)">{{role.name}}</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-success form-control m-t-10">Add Role</button>
        </div>
        <div class="modal fade" id="manage-role" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Edit Role {{editingRole.name}}</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="invite-member">Invite Members</label>
                                    <input type="checkbox" id="invite-member" v-model="editingRole.invite_member">
                                </div>
                                <div class="col-md-4">
                                    <label for="remove-member">Remove Members</label>
                                    <input type="checkbox" id="remove-member" v-model="editingRole.remove_member">
                                </div>
                                <div class="col-md-4">
                                    <label for="survey-view">View Surveys</label>
                                    <input type="checkbox" id="survey-view" v-model="editingRole.survey_view">
                                </div>
                                <div class="col-md-4">
                                    <label for="survey-create">Create Survey</label>
                                    <input type="checkbox" id="survey-create" v-model="editingRole.survey_create">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit-survey">Edit Surveys</label>
                                    <input type="checkbox" id="edit-survey" v-model="editingRole.survey_modify">
                                </div>
                                <div class="col-md-4">
                                    <label for="survey-delete">Delete Surveys</label>
                                    <input type="checkbox" id="survey-delete" v-model="editingRole.survey_delete">
                                </div>
                                <div class="col-md-4">
                                    <label for="respond-survey">Respond to Survey</label>
                                    <input type="checkbox" id="respond-survey" v-model="editingRole.survey_respond">
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <h3>Users with the role</h3>
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br/>
                            <ul>
                                <li v-for="error in errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-4" v-for="mem in membersWithRole">
                                <h4>{{mem.name}}</h4>
                                <button class="btn btn-danger m-t-10 form-control">Remove Role</button>
                            </div>
                            <div class="col-md-4">
                                <transition name="fade">
                                    <form v-if="showAddUser" @submit.prevent="addUser">
                                        <input type="text" class="form-control" id="add-user" placeholder="Enter Username" v-model="userToAdd" :disabled="addingUser"/>
                                    </form>
                                </transition>
                                <transition name="fade">
                                    <button class="form-control btn btn-default" v-if="!showAddUser" @click="showAddUser = true">Add User</button>
                                </transition>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return {
                roles: [],
                editingRole: {
                    name: ''
                },
                membersWithRole: [],
                showAddUser: false,
                userToAdd: "",
                addingUser: false,
                errors: []
            }
        },

        props: ['id'],

        mounted(){
            this.loadRoles();
        },

        methods: {
            loadRoles(){
                this.errors = [];
                this.$http.get('/api/role/' + this.id).then(resp=> {
                    this.roles = resp.data;
                });
            },

            editRole(role){
                this.editingRole = role;
                this.retrieveAssigned(role);
                $('#manage-role').modal('show');
            },

            retrieveAssigned(role){
                this.$http.get('/api/role/' + role.id + '/assigned').then(resp=> {
                    this.membersWithRole = resp.data;
                });
            },

            showUser(){
                this.showAddUser = true;
                $("#add-user").focus();
            },

            addUser(){
                this.addingUser = true;
                this.errors = [];
                this.$http.post('/api/role/' + this.editingRole.id + '/assign', {
                    user: this.userToAdd
                }).then(resp=> {
                    loadRoles();
                    this.addingUser = false;
                }).catch(response => {
                    if (typeof response.data === 'object') {
                        this.errors = _.flatten(_.toArray(response.data));
                    } else {
                        this.errors = ['Something went wrong. Please try again.'];
                    }
                    this.addingUser = false;
                });
            }
        }
    }
</script>