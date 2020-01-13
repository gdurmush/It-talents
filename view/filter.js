$(function(){

    let filter = document.querySelector('#filter');

    filter.addEventListener('click', () => {
        let checked = [];
        $("input:checkbox:checked").each(function () {
            let foo = $(this).parent().parent().data('filter');
            console.log(foo);


            let found = false;
            let index = -1;
            for (let i = 0; i < checked.length; i++) {
                if (checked[i].name === foo) {
                    found = true;
                    index = i;
                    break;
                }
            }
            let currentValue = $(this).val();
            if (found) {
                checked[index].checkedValues.push(currentValue);
            } else {

                let boo = {
                    name: foo,
                    checkedValues: [currentValue]
                };
                checked.push(boo);
            }
        });
        console.log(checked);
        $.post('index.php?target=product&action=filterProducts', {checked})
            .then((filtered) => {
                console.log(filtered)
                console.log("The type is: " + typeof(filtered));
                JSON.parse(filtered).forEach((product)=> {console.log(product)});
                vuejs.app.data.items = filtered;
            }).catch((err) => console.error(err));

    })
})
