@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">MedicAI</h1>

    <!-- Chatbox with clear outline -->
    <div id="chatbox" 
         class="border border-dark rounded p-3 mb-3 bg-light shadow-sm"
         style="min-height:200px; max-height:60vh; overflow-y:auto;">
    </div>

    <!-- Input group: Send button attached -->
    <div class="input-group mb-2">
        <input type="text" id="userInput" 
               class="form-control form-control-lg" 
               placeholder="Type your question..." />
        <button class="btn btn-primary btn-lg" onclick="sendMessage()">Send</button>
    </div>

    <!-- Clear Chat as secondary action -->
    <div class="text-end mb-3">
        <button class="btn btn-sm btn-outline-danger" onclick="clearChat()">Clear Chat</button>
    </div>
</div>

<style>
.chat-row {
    display: flex;
    align-items: flex-start;
    margin-bottom: 10px;
}
.chat-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    overflow: hidden;
}
.chat-message {
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 15px;
    word-wrap: break-word;
}
.chat-user {
    background-color: #0d6efd;
    color: white;
    margin-left: auto;
}
.chat-ai {
    background-color: #e9ecef;
    color: #212529;
    margin-right: auto;
}
.user-row {
    flex-direction: row-reverse;
}
.user-avatar {
    background-color: #0d6efd;
    color: white;
}
.ai-avatar {
    background-color: #6c757d;
    color: white;
}
</style>

<script>
function sendMessage() {
    const inputElement = document.getElementById("userInput");
    const userInput = inputElement.value.trim();
    if (!userInput) return;

    const chatbox = document.getElementById("chatbox");

    // User bubble
    const userRow = document.createElement("div");
    userRow.className = "chat-row user-row";
    userRow.innerHTML = `
        <div class="chat-avatar user-avatar">👤</div>
        <div class="chat-message chat-user">${userInput}</div>
    `;
    chatbox.appendChild(userRow);

    inputElement.value = "";

    // Typing indicator
    const typingRow = document.createElement("div");
    typingRow.className = "chat-row";
    typingRow.id = "typing";
    typingRow.innerHTML = `
        <div class="chat-avatar ai-avatar">🤖</div>
        <div class="chat-message chat-ai"><i>AI is thinking...</i></div>
    `;
    chatbox.appendChild(typingRow);

    fetch("{{ route('chatbot.query') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ question: userInput })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("typing").remove();

        // AI bubble
        const aiRow = document.createElement("div");
        aiRow.className = "chat-row";
        aiRow.innerHTML = `
            <div class="chat-avatar ai-avatar">🤖</div>
            <div class="chat-message chat-ai">${data.answer?.trim() || "Information unavailable"}</div>
        `;
        chatbox.appendChild(aiRow);

        // Sources
        if (data.sources && data.sources.length > 0) {
            const srcRow = document.createElement("div");
            srcRow.className = "chat-row";
            srcRow.innerHTML = `
                <div class="chat-avatar ai-avatar">🤖</div>
                <div class="chat-message chat-ai">
                    <small><b>Answer based on:</b> 
                    ${data.sources.map(src => `<span class='badge bg-info text-dark me-1'>${src}</span>`).join(" ")}
                    </small>
                </div>`;
            chatbox.appendChild(srcRow);
        }

        // Excerpts
        if (data.excerpts && Object.keys(data.excerpts).length > 0) {
            const accordionId = "sourceAccordion" + Date.now();
            let excerptsHtml = `<div class="accordion mt-2" id="${accordionId}">`;
            Object.keys(data.excerpts).forEach((src, idx) => {
                excerptsHtml += `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading${idx}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${idx}_${accordionId}" aria-expanded="false" aria-controls="collapse${idx}_${accordionId}">
                                Raw excerpts from ${src}
                            </button>
                        </h2>
                        <div id="collapse${idx}_${accordionId}" class="accordion-collapse collapse" aria-labelledby="heading${idx}" data-bs-parent="#${accordionId}">
                            <div class="accordion-body">
                                <pre style="white-space: pre-wrap;">${data.excerpts[src]}</pre>
                            </div>
                        </div>
                    </div>
                `;
            });
            excerptsHtml += `</div>`;

            const excerptsRow = document.createElement("div");
            excerptsRow.className = "chat-row";
            excerptsRow.innerHTML = `
                <div class="chat-avatar ai-avatar">🤖</div>
                <div class="chat-message chat-ai">${excerptsHtml}</div>`;
            chatbox.appendChild(excerptsRow);
        }

        chatbox.scrollTop = chatbox.scrollHeight;
    })
    .catch(error => {
        document.getElementById("typing").remove();
        const errRow = document.createElement("div");
        errRow.className = "chat-row";
        errRow.innerHTML = `
            <div class="chat-avatar ai-avatar">🤖</div>
            <div class="chat-message chat-ai text-danger"><b>Error:</b> ${error}</div>`;
        chatbox.appendChild(errRow);
    });
}

// Clear Chat
function clearChat() {
    document.getElementById("chatbox").innerHTML = "";
}
</script>
@endsection
