function convertDate(dateConverter) {
    const isoString = dateConverter; // Giả sử dateConverter chứa chuỗi ISO 8601
    const date = new Date(isoString);

    const options = {
        year: "numeric",
        month: "numeric",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
        hour12: true,
    };

    // Sử dụng locale phù hợp với định dạng ngày/tháng/năm của Việt Nam.  Tuy nhiên,  toLocaleString không đảm bảo tính nhất quán trên tất cả trình duyệt.
    const formattedDate = date
        .toLocaleString("vi-VN", options)
        .replace(
            /(\d{1,2})\/(\d{1,2})\/(\d{4}) (\d{1,2}):(\d{2}) (AM|PM)/,
            "$1/$2/$3 $4:$5 $6"
        );

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

function formatDateString(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Month is 0-indexed
    const year = date.getFullYear();

    return `${day}.${month}.${year}`;
}
