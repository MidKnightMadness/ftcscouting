<style>
    .member {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <!-- Member Overview -->
        <h3>Members ({{this.members.length}})</h3>
        <div class="member-block">
            <div class="col-md-2 col-xs-4 col-sm-4" v-for="member in members">
                <div class="member" @click="manageUser(member)">
                    <img :src="member.data.photo_location" class="member-image"/>
                    <div class="member-badge">{{member.name}}</div>
                </div>
            </div>
        </div>

        <!-- Manage User -->
        <div class="modal fade" id="manage-member" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-if="targetedMember">
                    <div class="modal-header">
                        <h4 class="modal-title">Manage User {{targetedMember.name}}</h4>
                    </div>
                    <div class="modal-body">
                        <img :src="targetedMember.data.photo_location"/>
                        <button class="btn btn-default">Transfer ownership</button>
                        <button class="btn btn-danger">Remove Member From Team</button>
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
                targetedMember: {
                    data: {}
                },
            }
        },

        mounted(){
            this.prepareComponent();
        },

        props: {
            number: {
                type: String,
                required: true
            }
        },

        methods: {
            prepareComponent(){
                this.fetchUsers();
            },

            fetchUsers(){
                this.$http.get('/api/team/' + this.number + '/members').then(response=> {
                    for (var i = 0; i < response.data.length; i++) {
                        this.fetchUser(response.data[i].user);
                    }
                });
            },

            fetchUser(username){
                this.$http.get('/api/user/' + username).then(response=> {
                    this.members.push(response.data);
                });
            },

            manageUser(user){
                this.targetedMember = user;
                $('#manage-member').modal('show');
            }
        }
    }
</script>