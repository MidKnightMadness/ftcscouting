<div class="panel panel-default">
    <div class="panel-heading">
        Profile Picture
    </div>
    <div class="panel-body">
        <form method="post" action="{{route('profile.edit.save')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="thumbnail">
                        <img src="{{Auth::user()->profileLarge()}}" alt="...">
                    </div>
                </div>
                <div class="col-xs-6 col-md-9">
                    <form-upload name="file-upload" display="Change Profile Picutre"></form-upload>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <toggle visible="{{\Auth::user()->data->gravatar? "true" : "false"}}" name="gravatar" display="Use Gravatar">
                        {!! Form::label('gravatar-email', 'Gravatar Email') !!}
                        {!! Form::text('gravatar-email', \Auth::user()->data->gravatar? Auth::user()->email == Auth::user()->data->photo_location? '' : \Auth::user()->data->photo_location : '', ['class'=>'form-control']) !!}
                        <p class="help-block">If left blank, your email address will be used</p>
                    </toggle>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-default form-control">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        Properties
    </div>
    <div class="panel-body">
        <settings-profile inline-template>
            <div>
                <div class="alert alert-success" v-if="forms.userData.successful">
                    Your profile has been updated
                </div>
                <form @submit.prevent="updateProfile">
                    <form-text display="Name" :form="forms.userData" input="name"></form-text>
                    <form-text display="Email" :form="forms.userData" input="email"></form-text>
                    <button type="submit" class="btn btn-success" @click.prevent="updateProfile" :disabled="forms.userData.busy">
                    <span v-if="forms.userData.busy">
                        <i class="fa fa-spin fa-spinner"></i> Working...
                    </span>
                        <span v-else>
                        Save
                    </span>
                    </button>
                </form>
            </div>
        </settings-profile>
    </div>
</div>