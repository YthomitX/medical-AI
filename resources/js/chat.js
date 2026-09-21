async function sendMessage() {
    let input = document.getElementById("input").value;
    if (!input.trim()) return;

    let messages = document.getElementById("messages");
    messages.innerHTML += `<div class="message user">${input}</div>`;
    document.getElementById("input").value = "";

    try {
        // Call Laravel proxy route
        let response = await fetch("/chatbot/query", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ question: input })
        });

        // Safe JSON parsing
        let data;
        try {
            data = await response.json();
        } catch (parseError) {
            console.error("Parse error:", parseError);
            messages.innerHTML += `<div class="message bot">Information unavailable</div>`;
            return;
        }

        // ✅ Ensure fallback if answer is missing or empty
        let answerText = (data.answer && data.answer.trim() !== "")
            ? data.answer
            : "Information unavailable";

        messages.innerHTML += `<div class="message bot">${answerText}</div>`;
    } catch (error) {
        console.error("Network error:", error);
        messages.innerHTML += `<div class="message bot">Information unavailable</div>`;
    }
}


