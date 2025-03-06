import './bootstrap';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

document.addEventListener("DOMContentLoaded", function() {
    ClassicEditor
        .create(document.querySelector("#editor"))
        .then(editor => {
            console.log("CKEditor 5 Loaded Successfully");

            // تأكد من أن الحقل مطلوب عند الإرسال
            document.querySelector("form").addEventListener("submit", function(e) {
                let editorData = editor.getData().trim();

                let existingError = document.querySelector("#editor-error");
                if (existingError) {
                    existingError.remove();
                }

                if (!editorData) {
                    e.preventDefault();
                    let errorMsg = document.createElement("small");
                    errorMsg.id = "editor-error";
                    errorMsg.classList.add("text-danger");
                    errorMsg.innerText = "هذا الحقل مطلوب!";
                    document.querySelector("#editor").parentNode.appendChild(errorMsg);
                }
            });
        })
        .catch(error => {
            console.error("CKEditor Initialization Error: ", error);
        });
});