import './bootstrap';

import Alpine from 'alpinejs';
import {aliasToReal} from "lodash/fp/_mapping";

window.Alpine = Alpine;

Alpine.start();

var channel = Echo.private(`App.Models.User.${userId}`);
channel.notification( function(data) {
    console.log(data);
    alert(data.body);
    alert(JSON.stringify(data));
});
