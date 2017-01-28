<style scoped>
    .member {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <!-- Member Overview -->
        <h3>Members ({{this.members.length}})</h3>
        <button class="btn btn-default" @click="inviteUser" style="margin-bottom: 10px" v-if="perms.invite">Invite User</button>
        <div class="member-block col-md-12">
            <div class="col-md-2 col-xs-4 col-sm-4" v-for="member in members">
                <div class="member" @click="manageUser(member)">
                    <img :src="member.user.data.photo_location" class="member-image"/>
                    <div class="member-badge">{{member.user.name}}</div>
                </div>
            </div>
        </div>
        <div class="member-block col-md-12" v-if="pending.length > 0">
            <h3>Pending Acceptance</h3>
            <div class="col-md-2 col-xs-4 col-sm-4" v-for="member in pending">
                <div class="member" @click="manageUser(member)">
                    <img :src="member.user.data.photo_location" class="member-image"/>
                    <div class="member-badge">{{member.user.name}}</div>
                </div>
            </div>
        </div>

        <!-- Manage User -->
        <div class="modal fade" id="manage-member" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-if="targetedMember">
                    <div class="modal-header">
                        <h4 class="modal-title">Manage User {{targetedMember.user.name}}</h4>
                    </div>
                    <div class="modal-body">
                        <img :src="targetedMember.user.data.photo_location"/>
                        <!--<button class="btn btn-default" v-if="!targetedMember.pending" disabled>Transfer ownership</button>-->
                        <div v-if="perms.remove" style="margin-top: 10px">
                            <button class="btn btn-danger" v-if="!targetedMember.pending" @click="cancelInvite(targetedMember.invite_id)">Remove Member From Team</button>
                            <button class="btn btn-danger" v-else @click="cancelInvite(targetedMember.invite_id)">Cancel Invite</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invite user -->
        <div class="modal fade" id="invite-user" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Invite user</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="forms.inviteUser.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br/>
                            <ul>
                                <li v-for="error in forms.inviteUser.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                        <p>
                            Enter the username of the member you wish to invite
                        </p>
                        <form @submit.prevent="sendInvite">
                            <div class="input-group">
                                <input type="text" name="username" v-model="forms.inviteUser.username" placeholder="Enter Username" class="form-control"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-success" type="button" @click="sendInvite">Send Invite!</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                members: [],
                pending: [],
                targetedMember: {
                    user: {
                        name: '',
                        data: {}
                    }
                },
                forms: {
                    inviteUser: {
                        errors: [],
                        username: ''
                    }
                },
                perms: {
                    invite: false,
                    remove: false,
                }
            }
        },

        mounted(){
            this.prepareComponent();
            this.fetchPerms();
        },

        props: {
            number: {
                type: String,
                required: true
            },
            id: {
                type: String,
                required: true
            }
        },

        methods: {
            prepareComponent(){
                this.fetchUsers();
            },

            fetchUsers(){
                axios.get('/api/team/' + this.number + '/members').then(response=> {
                    for (var i = 0; i < response.data.length; i++) {
                        if (response.data[i].pending) {
                            this.pending.push(response.data[i]);
                        } else {
                            this.members.push(response.data[i]);
                        }
                    }
                });
            },

            fetchPerms(){
                axios.get('/api/can/invite/' + this.id).then(resp => {
                    this.perms.invite = resp.data == "true";
                });
                axios.get('/api/can/remove_member/' + this.id).then(resp=> {
                    this.perms.remove = resp.data == "true";
                })
            },

            manageUser(user){
                this.targetedMember = user;
                $('#manage-member').modal('show');
            },

            inviteUser(){
                this.forms.inviteUser.errors = [];
                this.forms.inviteUser.username = '';
                $('#invite-user').modal('show');
            },

            sendInvite(){
                // Check if user exists
                axios.get('/api/user/' + this.forms.inviteUser.username).then(resp => {
                    // User exists, send invite
                    axios.post('/api/invite', {
                        username: this.forms.inviteUser.username,
                        teamNumber: this.number
                    }).then(response => {
                        this.members = [];
                        this.pending = [];
                        this.fetchUsers();
                        $('#invite-user').modal('hide');
                    }).catch(response => {
                        if (typeof response.data === 'object') {
                            this.forms.inviteUser.errors = _.flatten(_.toArray(response.data));
                        } else {
                            this.forms.inviteUser.errors = ['Something went wrong. Please try again.'];
                        }
                    });
                }).catch(response => {
                    if (typeof response.data === 'object') {
                        this.forms.inviteUser.errors = _.flatten(_.toArray(response.data));
                    } else {
                        this.forms.inviteUser.errors = ['Something went wrong. Please try again.'];
                    }
                });
            },

            cancelInvite(id){
                axios.post('/api/invite/cancel', {id: id}).then(resp => {
                    this.members = [];
                    this.pending = [];
                    $('#manage-member').modal('hide');
                    this.fetchUsers();
                });
            }
        }
    }
</script>