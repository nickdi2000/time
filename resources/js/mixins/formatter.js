export default {
  data: () => ({

  }),

  methods: {
    //converts a database array of order objects into a simple to read text version
    mix_compressOrder(orderObj, html = false){
      let breakChar = html ? "<br/>" : ", ";

      let res = [];
      for (let i = 0; i < orderObj.length; i++){
        res.push({
          'title' : orderObj[i].title,
          'id' : orderObj[i].id,
          'display_icon' : orderObj[i].display_icon
        });

      }
      return res;
    }
  }
}
