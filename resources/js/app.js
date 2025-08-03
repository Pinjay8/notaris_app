import PerfectScrollbar from "perfect-scrollbar";
window.PerfectScrollbar = PerfectScrollbar;

// // require('./bootstrap');
// require("./custom");
import { Notyf } from "notyf";
import "notyf/notyf.min.css";

window.notyf = new Notyf({
    duration: 3000,
    position: { x: "right", y: "top" },
});
