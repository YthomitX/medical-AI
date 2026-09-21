import axios from "axios";
import { BACKEND_URL } from "./config";

export async function sendMessage() {
    const inputElement = document.getElementById("input");
    const input = inputElement.value.trim();
    if (!input) return;

    const messages = document.getElementById("messages");
    messages.innerHTML += `<div class="message user">${input}</div>`;
    inputElement.value = "";

    try {
        const response = await axios.post(`${BACKEND_URL}/query`, { question: input });

        const answerText =
            response.data?.answer?.trim() !== "" ? response.data.answer : "Information unavailable";

        messages.innerHTML += `<div class="message bot">${answerText}</div>`;
    } catch (error) {
        console.error("Network error:", error);
        messages.innerHTML += `<div class="message bot">Information unavailable</div>`;
    }
}
