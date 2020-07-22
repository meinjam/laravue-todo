require("./bootstrap");

window.Vue = require("vue");
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
Vue.use(ElementUI);
import common from './common';
Vue.mixin(common);

Vue.component(
    "todo-component",
    require("./components/TodoComponent.vue").default
);

const app = new Vue({
    el: "#app"
});
