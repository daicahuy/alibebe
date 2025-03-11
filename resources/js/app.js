import "./bootstrap";

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: "pusher",
    key: "14773cf491b61b0bc6e2",
    cluster: "ap1",
    forceTLS: true,
    encrypted: true,
});

export function getHost() {
    return "http://127.0.0.1:8000";
}
