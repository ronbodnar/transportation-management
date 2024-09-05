var socket = io("https://ronbodnar.com:8080", { path: "/" });

socket.on("connect_error", (err) => {
  // just temporary so it doesn't attempt to reconnect when the server is not running
  if (err.message === 'xhr poll error') {
    socket.disconnect();
  }
});

socket.on("chat message", function (msg) {
  console.log("Message received: " + msg);
});

socket.on("connect", () => {
  console.log(socket.id); // x8WIv7-mJelg7on_ALbx
  socket.emit("setUser", { id:  sessionStorage.getItem("userId") });
});

socket.on("instructions", (msg) => {
  console.log("Instructions received: trailer: " + msg['trailerId'] + ", id: " + msg['shipmentId'] + ", source: " + msg['source']);
    $("div#instructions #details").html("I'm working");
    $("div#waiting").hide();
    $("div#instructions").show();
});

socket.on("disconnect", () => {
  console.log(socket.id); // undefined
});

function socketTest() {
    socket.emit("instructionsAccepted", { "accepted": true });
}