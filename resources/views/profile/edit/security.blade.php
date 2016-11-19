<settings-security inline-template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Change Password
            </div>
            <div class="panel-body">
                <div class="alert alert-success" v-if="forms.changePassword.successful">
                    Your password has been changed
                </div>
                <form @submit.prevent="savePassword">
                    <form-password display="Old Password" :form="forms.changePassword" input="current_password"></form-password>
                    <form-password display="New Password" :form="forms.changePassword" input="password"></form-password>
                    <form-password display="Confirm Password" :form="forms.changePassword" input="password_confirmation"></form-password>
                    <button type="submit" class="btn btn-success" :disabled="forms.changePassword.busy">
                        <span v-if="forms.changePassword.busy"><i class="fa fa-spinner fa-spin"></i> Working...</span>
                        <span v-else>Change Password</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</settings-security>