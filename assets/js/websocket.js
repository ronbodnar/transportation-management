var socket = io("https://mron.dev:8080", { path: "/" });

socket.on("chat message", function (msg) {
  console.log("Message received: " + msg);
});

socket.on("connect", () => {
  console.log(socket.id); // x8WIv7-mJelg7on_ALbx
  socket.emit("setUser", { id:  sessionStorage.getItem("userId") });
});

socket.on("instructions", (msg) => {
  console.log("Instructions received: trailer: " + msg['trailerId'] + ", id: " + msg['shipmentId'] + ", source: " + msg['source']);
    $("div#instructions #details").html("How the hell are ya..!");
    $("div#waiting").hide();
    $("div#instructions").show();
});

socket.on("disconnect", () => {
  console.log(socket.id); // undefined
});

function socketTest() {
    socket.emit("instructionsAccepted", { "accepted": true });
}