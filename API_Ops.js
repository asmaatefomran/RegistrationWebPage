
async function validateWhatsApp() {
    const whatsappNumber = document.querySelector("input[name='whatsapp']").value.trim();
    const whatsappErrSpan = document.querySelector("#whatsappErr");
    const validateBtn = document.querySelector("#validateWhatsappBtn");
    let isValid = false;

    whatsappErrSpan.innerText = "";

    if (whatsappNumber === "") {
        whatsappErrSpan.innerText = "Please enter a WhatsApp number first.";
        whatsappErrSpan.style.color = "red";
        return false;
    }

    if (!/^[0-9]{11}$/.test(whatsappNumber)) {
        whatsappErrSpan.innerText = "Invalid WhatsApp Number (must be 11 digits)";
        whatsappErrSpan.style.color = "red";
        return false;
    }

    validateBtn.disabled = true;
    validateBtn.innerText = "Validating...";
    
    const countryCode = "+2";
    let formattedNumber = countryCode + whatsappNumber;

    const url = 'https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken';
    const options = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-RapidAPI-Key": "5781c45302mshf7e3c7b407a86a3p137921jsndd01fdf934c6",

            "X-RapidAPI-Host": "whatsapp-number-validator3.p.rapidapi.com"
        },
        body: JSON.stringify({ phone_number: formattedNumber })
    };

    try {
        const response = await fetch(url, options);
        const data = await response.json();

        if (data.status === "valid") {
            whatsappErrSpan.innerText = "Valid WhatsApp number.";
            whatsappErrSpan.style.color = "green";
            isValid = true;
        } else {
            whatsappErrSpan.innerText = "Invalid WhatsApp number.";
            whatsappErrSpan.style.color = "red";
        }
    } catch (error) {
        console.error("Error validating WhatsApp number:", error);
        whatsappErrSpan.innerText = "Validation service unavailable. Please try again later.";
        whatsappErrSpan.style.color = "red";
    } finally {
        validateBtn.disabled = false;
        validateBtn.innerText = "Validate WhatsApp";
    }
    
    return isValid;
}