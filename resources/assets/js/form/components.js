Vue.component('form-text', {
    props: ['display', 'form', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(input)}">\
                <div class="row">\
                    <label class="col-md-5 control-label">{{ display }}</label>\
                    <div class="col-md-7">\
                        <input type="text" class="form-control" v-model="form[input]">\
                        <span class="help-block" v-show="form.errors.has(input)">\
                            <strong>{{ form.errors.get(input) }}</strong>\
                        </span>\
                    </div>\
                </div>\
            </div>'
});

Vue.component('form-email', {
    props: ['display', 'form', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(input)}">\
                <div class="row">\
                    <label class="col-md-5 control-label">{{ display }}</label>\
                    <div class="col-md-7">\
                        <input type="email" class="form-control" v-model="form[input]">\
                        <span class="help-block" v-show="form.errors.has(input)">\
                            <strong>{{ form.errors.get(input) }}</strong>\
                        </span>\
                    </div>\
                </div>\
            </div>'
});

Vue.component('form-password', {
    props: ['display', 'form', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(input)}">\
                <div class="row">\
                    <label class="col-md-5 control-label">{{ display }}</label>\
                    <div class="col-md-7">\
                        <input type="password" class="form-control" v-model="form[input]">\
                        <span class="help-block" v-show="form.errors.has(input)">\
                            <strong>{{ form.errors.get(input) }}</strong>\
                        </span>\
                    </div>\
                </div>\
            </div>'
});

Vue.component('form-select', {
        props: ['display', 'form', 'input', 'items'],

        template: '<div class="form-group" :class="{\'has-error\': form.errors.has(input)}">\
                <div class="row">\
                    <label class="col-md-5 control-label">{{ display }}</label>\
                    <div class="col-md-7">\
                        <select class="form-control" v-model="form[input]">\
                            <option v-for="item in items" :value="item.value">{{item.text}}</option>\
                        </select>\
                        <span class="help-block" v-show="form.errors.has(input)">\
                            <strong>{{ form.errors.get(input) }}</strong>\
                        </span>\
                    </div>\
                </div>\
            </div>'
    }
);