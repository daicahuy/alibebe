function convertDate(dateConverter) {
    const isoString = dateConverter;
    const date = new Date(isoString);

    // Định dạng tùy chỉnh
    const options = {
        hour: "numeric",
        minute: "numeric",
        hour12: true, // Sử dụng AM/PM
        month: "numeric",
        day: "numeric",
        year: "numeric",
    };

    const formattedDate = date.toLocaleString("en-US", options); // 'en-US' để có định dạng 12:30 PM

    return formattedDate;
}

function formatCurrency(money) {
    const parts = parseFloat(money).toFixed(2).split("."); // Tách phần nguyên và phần thập phân
    const integerPart = parts[0];
    const decimalPart = parts[1];

    let formattedInteger = "";
    for (let i = integerPart.length - 1, count = 0; i >= 0; i--, count++) {
        formattedInteger = integerPart[i] + formattedInteger;
        if (count % 3 === 2 && i !== 0) {
            formattedInteger = "." + formattedInteger;
        }
    }

    const formattedNumber = formattedInteger + "," + decimalPart; // Kết hợp lại
    return formattedNumber;
}
