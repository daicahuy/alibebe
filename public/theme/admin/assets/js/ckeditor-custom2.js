ClassicEditor.create(document.querySelector("#editor"))
    .then((editor) => {
        // Nhập dữ liệu vào CKEditor
        editor.setData("<p>Đây là nội dung được nhập vào CKEditor 5.</p>");

        // Vô hiệu hóa chỉnh sửa (read-only mode)
        editor.isReadOnly = true;
    })
    .catch((error) => {
        console.error(error);
    });
