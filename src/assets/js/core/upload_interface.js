export default class Upload {
  constructor(dz) {
    this.files = [];
    this.element = dz.dz_element;
  }

  //=======================================================================
  //Upload files
  //=======================================================================
  _upload = (params = {}) => {
    let plugin = this;
    const active = () => plugin.element.addClass("drag-over");
    const inactive = () => plugin.element.removeClass("drag-over");
    plugin.element.on("dragenter dragover dragleave drop", function (e) {
      e.preventDefault();
    });
    plugin.element.on("dragenter dragover", () => {
      active();
      return false;
    });
    plugin.element.on("dragleave drop", () => {
      inactive();
      return false;
    });
    plugin.element.on("click", (e) => {
      plugin._manageInputFile(e);
    });
    plugin.element.on("drop", (e) => {
      plugin.element.find(".button").prop("disabled", true).addClass("disable");
      let files = [...e.originalEvent.dataTransfer.files];
      plugin._handleDrop(files);
    });
    return plugin;
  };
  //=======================================================================
  //Handle Drop
  //=======================================================================
  _handleDrop = (files) => {
    let plugin = this;
    if (files.length != 0) {
      files = files.filter((file) => {
        let m_file = {};
        plugin.files.forEach((p_file) => {
          if (p_file.name == file.name && p_file.size == file.size) {
            m_file = p_file;
          }
        });
        return file.name != m_file.name && file.size != m_file.size;
      });
      for (let i = 0; i < files.length; i++) {
        let gallery_item = plugin._createGallery(URL.createObjectURL(files[i]));
        plugin._createExtraDiv(files[i], gallery_item);
        plugin.element.find(".gallery").append(gallery_item);
        plugin.files.push(files[i]);
      }
      plugin.element.on("click", ".gallery_item", function (e) {
        e.stopPropagation();
      });
      plugin._removeFiles();
    }
    if (plugin.files.length == 0) {
      plugin.element.find(".message").show();
    } else {
      plugin.element.find(".message").hide();
    }
  };
  //=======================================================================
  //Handle Drop
  //=======================================================================
  _manageInputFile = () => {
    let plugin = this;
    let inputEl = $("<input/>", {
      type: "file",
      multiple: "multiple",
    }).css("display", "none");
    inputEl.click();
    inputEl.on("change", function (e) {
      let files = [...e.originalEvent.path[0].files];
      plugin._handleDrop(files);
    });
  };
  //=======================================================================
  //Create image gallery
  //=======================================================================
  _createGallery = (value) => {
    var gallery_item = $("<div></div>").addClass("gallery_item");
    var img_remove = $("<div></div>").addClass("remove_item").text("Remove");
    var img_item = $("<div></div>").addClass("img_item");
    var img = $("<img />", {
      src: value,
    });
    img_item.append(img);
    return gallery_item.append(img_item, img_remove);
  };
  //=======================================================================
  //Create Extradiv for name and size
  //=======================================================================
  _createExtraDiv = (file, gallery_item) => {
    gallery_item.append(
      $("<div></div>")
        .text(file.name)
        .css("display", "none")
        .addClass("file_name")
    );
    gallery_item.append(
      $("<div></div>")
        .text(file.size)
        .css("display", "none")
        .addClass("file_size")
    );
  };
  //=======================================================================
  //Create file array
  //=======================================================================
  _createFile = async (url) => {
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "image/jpeg");
    // myHeaders.append("Content-Length", content.length.toString());
    myHeaders.append("Access-Control-Allow-Origin", "*");
    var myInit = {
      method: "POST",
      headers: myHeaders,
      mode: "cors",
      cache: "default",
    };
    let response = await fetch(url, myInit);
    let data = await response.blob();
    return new File([data], url.split(/[\\/]/).pop());
  };
  //=======================================================================
  //Remove File
  //=======================================================================
  _removeFiles = () => {
    let plugin = this;
    plugin.element.find(".remove_item").on("click", function (e) {
      e.stopPropagation();
      let gallery_item = $(this).parents(".gallery_item");
      gallery_item.remove();
      if (plugin.element.find(".gallery").children().length == 0) {
        plugin.element.find(".message").show();
        plugin.element
          .find(".button")
          .prop("disabled", false)
          .removeClass("disable");
      }
      let file_name = gallery_item.find(".file_name").text();
      let file_size = gallery_item.find(".file_size").text();
      plugin.files = plugin.files.filter((file) => {
        return file.name != file_name && file.size != file_size;
      });
    });
  };
  _manageErrors = (err_msg = "") => {
    let plugin = this;
    var error_div = $("<div></div>", { class: "error_message" });
    if (err_msg != "") {
      error_div.html(err_msg);
      plugin.element.append(error_div);
    }
  };
  _removeErrMsg = () => {
    let plugin = this;
    plugin.element.find(".error_message").on("click", function (e) {
      e.stopPropagation();
      $(this).remove();
    });
  };
}
