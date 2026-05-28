@extends('frontend.master_dashboard')
@section('main')

<!--===== HEADER AREA =====-->
<div class="about-header-area" style="background-color: #ED7032">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto text-center">
                <div class="about-inner-header heading9">
                    <h3 style="font-family: 'Cairo', sans-serif;color:white">تواصل عبر الذكاء الاصطناعي</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===== CHATBOT AREA =====-->
<div class="chatbot-container">
    <div class="chat-header">
        <h5>🤖 المساعد الذكي</h5>
    </div>

    <div class="chat-body" id="chatBody">
        <!-- رسالة ترحيب -->
        <div class="message bot-message">
            مرحباً 👋، كيف أقدر أساعدك اليوم؟
        </div>
    </div>

    <div class="chat-footer">
        <form id="chatForm" onsubmit="sendMessage(event)">
            <input type="text" id="userMessage" placeholder="اكتب رسالتك هنا..." autocomplete="off" required>

            <!-- زر تسجيل الصوت -->
            <button type="button" id="voiceBtn" title="تسجيل صوت">🎤</button>

            <!-- زر الإرسال -->
            <button type="submit">إرسال</button>
        </form>
    </div>
</div>

<style>
    .chatbot-container {
        max-width: 800px;
        margin: 30px auto;
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        height: 75vh;
    }

    .chat-header {
        background: var(--primary-color, #ED7032);
        color: #fff;
        padding: 15px;
        text-align: center;
        font-family: 'Cairo', sans-serif;
        font-size: 18px;
        font-weight: bold;
    }

    .chat-body {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background: #f9f9f9;
        display: flex;
        flex-direction: column;
    }

    .message {
        max-width: 80%;
        padding: 10px 15px;
        border-radius: 12px;
        margin: 8px 0;
        font-family: 'Cairo', sans-serif;
        font-size: 15px;
        word-wrap: break-word;
    }

    .bot-message {
        background: #ececec;
        color: #333;
        align-self: flex-start;
    }

    .user-message {
        background: var(--primary-color, #ED7032);
        color: #fff;
        align-self: flex-end;
    }

    .chat-footer {
        display: flex;
        border-top: 1px solid #ddd;
        background: #fff;
    }

    .chat-footer form {
        display: flex;
        width: 100%;
        align-items: center;
    }

    .chat-footer input {
        flex: 1;
        border: none;
        padding: 12px 15px;
        font-family: 'Cairo', sans-serif;
        font-size: 15px;
    }

    .chat-footer input:focus {
        outline: none;
    }

    /* زر الصوت 🎤 */
    #voiceBtn {
        background: #555;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin: 0 5px;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #voiceBtn.recording {
        background: red;
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.6; }
        100% { opacity: 1; }
    }

    /* زر الإرسال */
    .chat-footer button[type="submit"] {
        background: var(--primary-color, #ED7032);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .chat-footer button[type="submit"]:hover {
        background: #d95d21;
    }

    /* موبايل */
    @media (max-width: 768px) {
        .chatbot-container {
            max-width: 100%;
            height: 80vh;
            border-radius: 0;
        }
    }
</style>

<script>
    function sendMessage(event) {
        event.preventDefault();
        let input = document.getElementById("userMessage");
        let message = input.value.trim();

        if(message === "") return;

        // رسالة المستخدم
        let chatBody = document.getElementById("chatBody");
        let userMsg = document.createElement("div");
        userMsg.classList.add("message", "user-message");
        userMsg.textContent = message;
        chatBody.appendChild(userMsg);

        input.value = "";
        chatBody.scrollTop = chatBody.scrollHeight;

        // رد تجريبي
        setTimeout(() => {
            let botMsg = document.createElement("div");
            botMsg.classList.add("message", "bot-message");
            botMsg.textContent = "👋 هذه رسالة تجريبية من البوت.";
            chatBody.appendChild(botMsg);
            chatBody.scrollTop = chatBody.scrollHeight;
        }, 800);
    }

    // 🎤 تسجيل الصوت
    let recognition;
    const voiceBtn = document.getElementById("voiceBtn");

    if ('webkitSpeechRecognition' in window) {
        recognition = new webkitSpeechRecognition();
        recognition.lang = "ar-SA";
        recognition.continuous = false;

        recognition.onresult = function(event) {
            document.getElementById("userMessage").value = event.results[0][0].transcript;
        };

        recognition.onstart = function() {
            voiceBtn.classList.add("recording");
        };

        recognition.onend = function() {
            voiceBtn.classList.remove("recording");
        };

        voiceBtn.addEventListener("click", () => {
            recognition.start();
        });
    } else {
        voiceBtn.disabled = true;
        voiceBtn.title = "المتصفح لا يدعم التسجيل الصوتي";
    }
</script>

@endsection
