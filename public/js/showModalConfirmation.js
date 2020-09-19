function showModalConfirmation(controller, id, title, body) {
    let confirmLink = $("#confirm-href");
    confirmLink.attr("href", "/" + controller + "/" + id + "/remove");

    let modalTitle = $(".modal-title");
    modalTitle.text("Удаление " + title);

    let modalBody = $(".modal-body");
    modalBody.text("Вы действительно хотите удалить " + body + "?");
}
