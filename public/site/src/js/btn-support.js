// function initBtnSupport() {
//     const btnSupport = document.querySelector('#btn-support');
//     const scrollOffset = 200

//     if (btnSupport) {
//         window.addEventListener("scroll", function () {
//             if (document.body.scrollTop > scrollOffset // For Safari
//                 || document.documentElement.scrollTop > scrollOffset // For Chrome, Firefox, IE and Opera
//             ) {
//                 btnSupport.classList.add('show');
//             } else {
//                 btnSupport.classList.remove('show');
//             }
//         })
//     }
// }

// window.addEventListener("DOMContentLoaded", function () {
//     initBtnSupport()
// })
function initBtnSupport() {
    const btnSupport = document.querySelector("#btn-support");
    const scrollOffset = 200;

    if (btnSupport) {
        window.addEventListener("scroll", function () {
            const scrollTop =
                document.documentElement.scrollTop || document.body.scrollTop;
            const windowHeight = window.innerHeight;
            const docHeight = document.documentElement.scrollHeight;

            // نمایش دکمه
            if (scrollTop > scrollOffset) {
                btnSupport.classList.add("show");
            } else {
                btnSupport.classList.remove("show");
            }

            // وقتی رسید به انتهای صفحه
            if (scrollTop + windowHeight >= docHeight - 20) {
                btnSupport.classList.add("at-bottom");
            } else {
                btnSupport.classList.remove("at-bottom");
            }
        });
    }
}

window.addEventListener("DOMContentLoaded", function () {
    initBtnSupport();
});

// chat

document.addEventListener("DOMContentLoaded", function () {
    const chatBtn = document.getElementById("chatBtn");
    const closeBtn = document.getElementById("closeBtn");
    const chatBox = document.getElementById("chatBox");
    const chatHeader = document.getElementById("chatHeader");
    const chatBody = document.getElementById("chatBody");
    const chatFooter = document.getElementById("chatFooter");
    const messageInput = document.getElementById("messageInput");
    const sendBtn = document.getElementById("sendBtn");
    const chatIcon = document.getElementById("chatIcon");

    let isOpen = false;
    let isAnimating = false;

    // Open chat box
    chatBtn.addEventListener("click", function () {
        if (!isOpen && !isAnimating) {
            isAnimating = true;
            document.getElementById("btn-support").style.borderRadius = "9px";

            // Step 1: Expand width first
            chatBox.classList.add("expand-width");
            // chatIcon.style.transform = "rotate(360deg)";

            setTimeout(() => {
                chatBtn.style.display = "none";
                // Step 2: Expand height after width expansion is complete
                document.getElementById("btn-support").style.outlineWidth = "15px";
                chatBox.classList.add("expand-height");

                setTimeout(() => {
                    // Show content after both animations are complete
                    chatHeader.classList.add("show-content");
                    chatBody.classList.add("show-content");
                    chatFooter.classList.add("show-content");

                    isOpen = true;
                    isAnimating = false;
                }, 400);
            }, 400);
        }
    });

    // Close chat box
    closeBtn.addEventListener("click", function () {
        if (isOpen && !isAnimating) {
            isAnimating = true;

            chatBtn.style.display = "flex";
            // Hide content first
            chatHeader.classList.remove("show-content");
            chatBody.classList.remove("show-content");
            chatFooter.classList.remove("show-content");

            setTimeout(() => {
                // Step 1: Collapse height first
                chatBox.classList.remove("expand-height");
                chatBox.classList.add("collapse-height");

                setTimeout(() => {
                    // Step 2: Collapse width after height collapse is complete
                    chatBox.classList.remove("expand-width");
                    chatBox.classList.add("collapse-width");
                    document.getElementById("btn-support").style.borderRadius =
                        "50%";
                    document.getElementById("btn-support").style.outlineWidth =
                        "0px";

                    setTimeout(() => {
                        chatBox.classList.remove("collapse-height");
                        chatBox.classList.remove("collapse-width");
                        // chatIcon.style.transform = "rotate(0deg)";

                        isOpen = false;
                        isAnimating = false;
                    }, 400);
                }, 400);
            }, 50);
        }
    });

    // Send message
    sendBtn.addEventListener("click", sendMessage);
    messageInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });

    function sendMessage() {
        const message = messageInput.value.trim();
        if (message !== "") {
            const now = new Date();
            const time =
                now.getHours() +
                ":" +
                (now.getMinutes() < 10 ? "0" : "") +
                now.getMinutes();

            const messageElement = document.createElement("div");
            messageElement.classList.add("message", "sent");
            messageElement.innerHTML =
                message + '<span class="message-time">' + time + "</span>";

            chatBody.appendChild(messageElement);
            messageInput.value = "";

            // Scroll to bottom
            chatBody.scrollTop = chatBody.scrollHeight;

            // Simulate reply after a short delay
            setTimeout(() => {
                const replyElement = document.createElement("div");
                replyElement.classList.add("message", "received");
                replyElement.innerHTML =
                    'پیام شما دریافت شد. همکاران ما به زودی با شما تماس خواهند گرفت.<span class="message-time">' +
                    time +
                    "</span>";

                chatBody.appendChild(replyElement);
                chatBody.scrollTop = chatBody.scrollHeight;
            }, 1000);
        }
    }
});
