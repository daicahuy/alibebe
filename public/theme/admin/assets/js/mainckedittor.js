const {
    ClassicEditor,
    Autosave,
    BlockQuote,
    Bold,
    Essentials,
    GeneralHtmlSupport,
    Heading,
    HtmlEmbed,
    Indent,
    IndentBlock,
    Italic,
    Link,
    Paragraph,
    ShowBlocks,
    SpecialCharacters,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextPartLanguage,
    Title,
    Underline,
    WordCount,
} = window.CKEDITOR;

const LICENSE_KEY =
    "eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3MzY0NjcxOTksImp0aSI6IjhhZmYxOGFiLWM5ODQtNDYyMi05YzVlLTFjMjRmNDU5M2ZiOSIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6IjcwZjM5ODMxIn0.-uQI_525MDeAVaIAVznKRKcbDavKpfPrXBKU6Y2G73ohgqpTdS0A8wXmlIYK9zYfXL-MR0-fYjeEwaZtyhftpA";

const editorConfig = {
    toolbar: {
        items: [
            "showBlocks",
            "textPartLanguage",
            "|",
            "heading",
            "|",
            "bold",
            "italic",
            "underline",
            "|",
            "specialCharacters",
            "link",
            "insertTable",
            "blockQuote",
            "htmlEmbed",
            "|",
            "outdent",
            "indent",
        ],
        shouldNotGroupWhenFull: false,
    },
    plugins: [
        Autosave,
        BlockQuote,
        Bold,
        Essentials,
        GeneralHtmlSupport,
        Heading,
        HtmlEmbed,
        Indent,
        IndentBlock,
        Italic,
        Link,
        Paragraph,
        ShowBlocks,
        SpecialCharacters,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextPartLanguage,
        Title,
        Underline,
        WordCount,
    ],
    heading: {
        options: [
            {
                model: "paragraph",
                title: "Paragraph",
                class: "ck-heading_paragraph",
            },
            {
                model: "heading1",
                view: "h1",
                title: "Heading 1",
                class: "ck-heading_heading1",
            },
            {
                model: "heading2",
                view: "h2",
                title: "Heading 2",
                class: "ck-heading_heading2",
            },
            {
                model: "heading3",
                view: "h3",
                title: "Heading 3",
                class: "ck-heading_heading3",
            },
            {
                model: "heading4",
                view: "h4",
                title: "Heading 4",
                class: "ck-heading_heading4",
            },
            {
                model: "heading5",
                view: "h5",
                title: "Heading 5",
                class: "ck-heading_heading5",
            },
            {
                model: "heading6",
                view: "h6",
                title: "Heading 6",
                class: "ck-heading_heading6",
            },
        ],
    },
    htmlSupport: {
        allow: [
            {
                name: /^.*$/,
                styles: true,
                attributes: true,
                classes: true,
            },
        ],
    },
    initialData: "",
    language: "vi",
    licenseKey: LICENSE_KEY,
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: "https://",
        decorators: {
            toggleDownloadable: {
                mode: "manual",
                label: "Downloadable",
                attributes: {
                    download: "file",
                },
            },
        },
    },
    placeholder: "Type or paste your content here!",
    table: {
        contentToolbar: [
            "tableColumn",
            "tableRow",
            "mergeTableCells",
            "tableProperties",
            "tableCellProperties",
        ],
    },
};

ClassicEditor.create(document.querySelector("#editor"), editorConfig).then(
    (editor) => {
        const wordCount = editor.plugins.get("WordCount");
        document
            .querySelector("#editor-word-count")
            .appendChild(wordCount.wordCountContainer);

        return editor;
    }
);
