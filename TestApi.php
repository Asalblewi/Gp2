<!DOCTYPE html>
<html>
<head>
  <title>صفحة HTML الرئيسية</title>
  <style>
    .chat-input {
      display: flex;
      align-items: center;
    }
    .chat-input textarea {
      height: 40px;
      flex: 1;
    }
    .chat-input button {
      margin-left: 10px;
    }
  </style>
</head>
<body>
  <div class="chat-input">
    <textarea id="userInput" placeholder="أدخل رابط اليوتيوب"></textarea>
    <button id="sendBtn">إرسال</button>
  </div>

  <ul class="chatbox"></ul>

  <script>
    const chatInput = document.querySelector("#userInput");
    const sendChatBtn = document.querySelector("#sendBtn");
    const chatbox = document.querySelector(".chatbox");

    let userMessage;
    let API_KEY = "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";
    let role = "Summarize the video from link to text as dots";

    const inputInitHeight = chatInput.scrollHeight;

    const createChatLi = (message, className) => {
      const chatLi = document.createElement("li");
      chatLi.classList.add("chat", className);
      chatLi.innerHTML = `<p>${message}</p>`;
      return chatLi;
    };

    const generateResponse = (incomingChatLi) => {
      const API_URL = "https://api.openai.com/v1/chat/completions";
      const messageElement = incomingChatLi.querySelector("p");

      const requestOptions = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${API_KEY}`,
        },
        body: JSON.stringify({
          model: "gpt-3.5-turbo",
          messages: [
            { role: "system", content: "You are a chatbot" },
            { role: "user", content: role + userMessage },
          ],
        }),
      };

      fetch(API_URL, requestOptions)
        .then((res) => res.json())
        .then((data) => {
          messageElement.textContent = data.choices[0].message.content;
        })
        .catch((error) => {
          messageElement.classList.add("error");
          messageElement.textContent = "Ooops! something went wrong. Please try again.";
        })
        .finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));
    };

    const handleChat = () => {
      userMessage = chatInput.value;
      if (!userMessage) return;

      chatInput.value = "";
      chatInput.style.height = `${inputInitHeight}px`;

      chatbox.appendChild(createChatLi(userMessage, "outgoing"));
      chatbox.scrollTo(0, chatbox.scrollHeight);

      setTimeout(() => {
        const incomingChatLi = createChatLi("Thinking...", "incoming");
        chatbox.appendChild(incomingChatLi);
        chatbox.scrollTo(0, chatbox.scrollHeight);
        generateResponse(incomingChatLi);
      }, 600);
    };

    chatInput.addEventListener("input", () => {
      chatInput.style.height = `${inputInitHeight}px`;
      chatInput.style.height = `${chatInput.scrollHeight}px`;
    });

    chatInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        handleChat();
      }
    });

    sendChatBtn.addEventListener("click", handleChat);
  </script>
</body>
</html>