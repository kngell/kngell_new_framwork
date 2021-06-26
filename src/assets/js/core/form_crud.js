import { param } from "jquery";
import { BASE_URL, isIE } from "./config";

//display all details
export function displayAllDetails(data, gestion) {
  const form_data = data.hasOwnProperty("frm")
    ? new FormData(data.frm[0])
    : new FormData();
  form_data.append("isIE", isIE());
  $.each(data, function (key, val) {
    if (typeof val === "object") {
      for (const [k, v] of Object.entries(val)) {
        form_data.append(k, JSON.stringify(v));
      }
    } else if (val instanceof Array) {
      for (let i = 0; i < val.length; i++) {
        form_data.append(val[i].name, data.files[i]);
      }
    } else {
      form_data.append(key, val);
    }
  });
  $.ajax({
    url: BASE_URL + data.url,
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (response) {
      gestion(response, data.params ? data.params : "");
    },
  });
}
//edit data
export function editForm(data, gestion) {
  $.ajax({
    url: BASE_URL + data.url,
    method: "post",
    data: data.formData,
    success: function (response) {
      gestion(response, data.params ? data.params : "");
    },
  });
}

//display all Items
export function displayAllItems(data, gestion) {
  const form_data = new FormData();
  form_data.append("isIE", isIE());
  $.each(data, function (key, val) {
    form_data.append(key, val);
  });
  $.ajax({
    url: BASE_URL + data.url,
    method: "POST",
    contentType: false,
    processData: false,
    data: form_data,
    success: function (response) {
      gestion(response, data.params ? data.params : "");
    },
  });
}

//add Item
export function Add(data, gestion) {
  var formData = new FormData(data.frm[0]);
  formData.append("isIE", isIE());
  $.each(data, function (key, val) {
    if (typeof val === "object") {
      for (const [k, v] of Object.entries(val)) {
        formData.append(k, JSON.stringify(v));
      }
    } else if (val instanceof Array) {
      for (let i = 0; i < val.length; i++) {
        formData.append(val[i].name, data.files[i]);
      }
    } else {
      formData.append(key, val);
    }
  });
  $.ajax({
    url: BASE_URL + data.url,
    method: "post",
    data: formData,
    cache: false,
    processData: false,
    contentType: false,
    success: function (response) {
      gestion(response, data.params ? data.params : "");
    },
  });
}
function get_formData(data) {
  var formData = data.hasOwnProperty("frm")
    ? new FormData(data.frm[0])
    : new FormData();
  formData.append("frm_name", data.frm_name);
  formData.append("isIE", isIE());
  $.each(data, function (key, val) {
    if (key != "frm") {
      if (val instanceof Object) {
        if (key == "select2") {
          for (const [k, v] of Object.entries(val)) {
            formData.append(k, JSON.stringify(v));
          }
          // formData.append(key, JSON.stringify(val));
        } else if (key == "files") {
          for (let i = 0; i < val.length; i++) {
            formData.append(val[i].name, data.files[i]);
          }
        } else {
          formData.append(key, JSON.stringify(val));
        }
      } else if (val instanceof Array) {
        for (let i = 0; i < val.length; i++) {
          formData.append(val[i].name, data.files[i]);
        }
      } else {
        formData.append(key, val);
      }
    }
  });
  return formData;
}
/**
 *
 * @param {*} data
 * @param {*} gestion
 */
export function Call_controller(data, gestion) {
  const formData = get_formData(data);
  $.ajax({
    url: BASE_URL + data.url,
    method: "POST",
    processData: false,
    contentType: false,
    dataType: "json",
    data: formData,
    success: function (response) {
      gestion(response, data.params ? data.params : "");
    },
    error: function (request, status, error) {
      console.log(request.responseText, error);
    },
  });
}

//delete
export function Delete(data, displayItem) {
  checkBeforeDelete(data).then((result) => {
    if (result.value) {
      $.ajax({
        url: BASE_URL + data.url,
        method: "post",
        data: data.serverData,
        success: function (response) {
          displayItem(response, data.params ? data.params : "");
        },
      });
    }
  });
}
//function check before delete
function checkBeforeDelete(data) {
  return new Promise((resolve, reject) => {
    if (!data.url_check) {
      const html = () => {
        const htw = document.createElement("div");
        if (data.swal_message) {
          return (htw.innerHTML = data.swal_message);
        } else {
          return (htw.innerHTML = "<p>You won't be able to revert this!</p>");
        }
      };
      data.swal
        .fire({
          title: "Are you sure?",
          showCancelButton: true,
          html: html(),
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: data.swal_button ? data.swal_button : "Delete!",
        })
        .then((result) => {
          resolve(result);
        });
    } else {
      $.ajax({
        url: BASE_URL + data.url_check,
        method: "post",
        data: data.serverData,
      })
        .done((response) => {
          data.swal
            .fire({
              title: "Are you sure?",
              showCancelButton: true,
              html: "<p>You won't be able to revert this!</p>" + response.msg,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Delete!",
            })
            .then((result) => {
              resolve(result);
            });
        })
        .fail((error) => {
          reject(error);
        });
    }
  });
}
export function displayMultisellect(data) {
  $.ajax({
    url: BASE_URL + "forms/fillMultiselect",
    method: "post",
    data: {
      table: data.table,
    },
    success: function (response) {
      if (response.result === "success") {
        data.displayID.append(response.msg);
      } else {
        data.alertID.html(response.msg);
      }
    },
  });
}

export function addCategorrie(catField, alertID) {
  let cat = document.querySelector(catField);
  if (cat.value.length == 0) {
    alert("Le champs catégorie est vide");
  } else {
    $.ajax({
      url: BASE_URL + "forms/addcategorie",
      method: "post",
      data: {
        categorie: cat.value,
      },
      success: function (response) {
        if (response != "success") {
          $(alertID).html(response);
        }
      },
    });
  }
}
export function select2AjaxParams(data) {
  var formData = get_formData(data);
  return {
    url: BASE_URL + data.url,
    type: "post",
    delay: 250,
    processData: false,
    contentType: false,
    dataType: "json",
    data: function (params) {
      formData.append("searchTerm", params.term);
      return formData;
    },
    processResults: function (response) {
      if (response.result == "success") {
        return {
          results: $.map(response.msg, function (obj) {
            return { id: obj.id, text: obj.text };
            // if (obj.id != 0) {
            //   return { id: obj.id, text: obj.text };
            // } else {
            //   return { id: obj.id, text: obj.text };
            // }
          }),
        };
      }
    },
    cache: true,
  };
}
export function Call(data) {
  let dt = new FormData();
  for (const [key, value] of Object.entries(data.params)) {
    dt.append(key, value);
  }
  $.ajax({
    url: BASE_URL + data.url,
    method: "POST",
    processData: false,
    contentType: false,
    dataType: "json",
    data: dt,
    success: function (response) {},
  });
}
