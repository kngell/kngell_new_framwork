//=======================================================================
//Css entries
//=======================================================================
module.exports = {
  entry: {
    //Front pages
    "css/main/backend/members/main": {
      import: ["css/main/backend/main.scss"],
      dependOn: "css/librairies/backend/members/lib",
    },
  },
};
