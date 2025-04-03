
async function validateWhatsApp() {
    const whatsappNumber = document.querySelector("input[name='whatsapp']").value.trim();
    const whatsappErrSpan = document.querySelector("#whatsappErr");
    const validateBtn = document.querySelector("#validateWhatsappBtn");

    whatsappErrSpan.innerText = "";

    if (whatsappNumber === "") {
        whatsappErrSpan.innerText = "Please enter a WhatsApp number first.";
        whatsappErrSpan.style.color = "red";
        return;
    }

    validateBtn.disabled = true;
    validateBtn.innerText = "Validating...";
    
    const countryCode = "+2"; 
    let formattedNumber = whatsappNumber;
    formattedNumber = countryCode + formattedNumber; //  +201102480558

    const url = 'https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken';
    const options = {
            method: "POST",
            headers: {
                    "Content-Type": "application/json",
                    "X-RapidAPI-Key": "5178bbfd76mshe4c2e2958ea70c3p1d5c95jsnf5f86ed85a1c",
                    "X-RapidAPI-Host": "whatsapp-number-validator3.p.rapidapi.com"
            },
            body: JSON.stringify({ phone_number: formattedNumber })
    };

    try {
        const response = await fetch(url, options);
        const data = await response.json();

        console.log("API Response:", data);

        if (data.status === "valid") {
            whatsappErrSpan.innerText = "Valid WhatsApp number.";
            whatsappErrSpan.style.color = "green";
        } else {
            whatsappErrSpan.innerText = "Invalid WhatsApp number.";
            whatsappErrSpan.style.color = "red";
        }
    } catch (error) {
        console.error("Error validating WhatsApp number:", error);
        whatsappErrSpan.innerText = "An error occurred while validating the number.";
        whatsappErrSpan.style.color = "red";
    } finally {
            validateBtn.disabled = false;
            validateBtn.innerText = "Validate WhatsApp";
    }
}
