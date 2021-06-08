//=======================================================================
//Js entries
//=======================================================================
module.exports = {
  entry: {
    //main js
    "js/main/backend/members/main": {
      import: ["js/main/backend/members/main.js"],
      dependOn: "js/librairies/backend/members/lib",
    },
  },
};
