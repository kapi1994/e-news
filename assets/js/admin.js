$(document).ready(function () {
    // categories
    $(document).on('click', '#btnCategory', function (e) {
        e.preventDefault();
        categoryFromRequestAndValidation()
    })
    $(document).on('click', '.delete-category', function (e) {
        e.preventDefault()
        let id = $(this).data('id')

        $.ajax({
            method: 'post',
            url: 'models/categories/delete.php',
            data: { id: id },
            dataType: "json",
            success: function (data, statusTxt, xhr) {

                if (xhr.status == 204) {

                    getAllCategories()
                }
            },
            error: function (jqXHR, statusTxt, xhr) {
                printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#categoryResponseMessages', 'warning,danger')
            }
        })
    })

    // headings
    $(document).on('click', '.delete-heading', function (e) {
        e.preventDefault();
        let id = $(this).data('id')
        $.ajax({
            method: 'post',
            url: 'models/headings/delete.php',
            data: { id: id },
            dataType: 'json',
            success: function (data, statusTxt, xhr) {
                if (xhr.status == 204) {
                    getAllHeadings()
                }
            },
            error: function (jqXHR, statusTxt, xhr) {
                printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#headingResponseMessages', 'warning,danger')
            }
        })
    })
    $(document).on('click', '#btnHeading', function (e) {
        e.preventDefault()
        headingFromRequestAndValidation()
    })

    $(document).on('keyup', '#searchHeadings', function (e) {
        e.preventDefault()
        let text = $(this).val()
        filterHeading()
    })

    $(document).on('change', '#sortHeading', function (e) {
        e.preventDefault()
        let id = $(this).val()
        filterHeading()
    })
    $(document).on('click', '.heading-pagination', function (e) {
        e.preventDefault()
        let limit = $(this).data('limit')
        filterHeading(limit)
    })
    const filterHeading = (data) => {
        filterHeadings(data)
    }

    const filterHeadings = (d) => {
        let text = $('#searchHeadings').val()
        let ordering = $('#sortHeading').val()
        $.ajax({
            method: "GET",
            url: 'models/headings/filter.php',
            data: {
                text: text,
                order: ordering,
                limit: d
            },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                printAllHeadings(data.headings, data.limit)
                printPagination(data.pages, '#headingPagination', data.limit, 'heading-pagination')
            }, error: function (err) {
                console.log(err)
            }
        })
    }


    // tags 

    $(document).on('click', '.delete-tag', function (e) {
        e.preventDefault()
        let id = $(this).data('id')
        $.ajax({
            method: 'post',
            url: 'models/tags/delete.php',
            data: { id: id },
            dataType: 'json',
            success: function (data, statusTxt, xhr) {
                // console.log(xhr.status)
                if (xhr.status == 204) {
                    getAllPosts()
                }
            }, error: function (jqXHR, statusTxt, xhr) {

                printResponseMessages(jqXHR.status, jqXHR.responseJSON, "#printTagCrudMessage", 'warning,danger')
            }
        })
    })
    $(document).on('click', '#btnTag', function (e) {
        e.preventDefault()
        tagsFormValidationAndRequest()
    })

    $(document).on('keyup', '#searchTags', function (e) {
        e.preventDefault()
        let text = $(this).val()
        filterTags()
    })
    $(document).on("change", '#orderTags', function (e) {
        e.preventDefault()
        let tags = $(this).val()
        filterTags()
    })
    $(document).on('click', '.tag-pagination', function (e) {
        e.preventDefault()
        let limit = $(this).data('limit')
        filterTags(limit)
    })
    const filterTags = (d) => {

        filterTag(d)
    }
    const filterTag = (lim) => {

        let text = $('#searchTags').val()
        let tagOrder = $('#orderTags').val()
        $.ajax({
            method: 'get',
            url: 'models/tags/filter.php',
            data: {
                text: text,
                order: tagOrder,
                limit: lim
            },
            success: function (data) {

                printAllTags(data.tags, data.limit)
                printPagination(data.pages, '#tagPagination', data.limit, 'tag-pagination')
            }, error: function (err) { }
        })
    }
    // posts 
    $(document).on('click', '.delete-post', function (e) {
        e.preventDefault()
        let id = $(this).data('id')
        $.ajax({
            method: 'post',
            url: 'models/posts/delete.php',
            data: { id: id },
            dataType: 'json',
            success: function (data, statusTxt, xhr) {
                // console.log(xhr.status)
                if (xhr.status == 204) {
                    getAllPosts()
                }
            }, error: function (jqXHR, statusTxt, xhr) {
                printResponseMessages(jqXHR.status, jqXHR.responseJSON, "#printPostCrudMessage", 'warning,danger')
            }
        })
    })
    $(document).on('click', '#submitPost', function (e) {
        e.preventDefault()
        postFormVaildationAndRequest()
    })


    $(document).on('change', '#postCategory', function (e) {
        e.preventDefault()
        let id = $(this).val()
        document.querySelector('#postHeading').value = 0
        document.querySelector('#heading_tag').innerHTML = ''
        $.ajax({
            method: "GET",
            url: "models/posts/getHeadingsByCategory.php",
            data: { id: id },
            dataType: 'json',
            success: function (data, statusTxt, xhr) {
                printPostHeadings(data)
            },
            error: function (jqXHR, statusTxt, xhr) {
                console.log(xhr)
            }
        })
    })
    $(document).on('change', '#postHeading', function (e) {
        e.preventDefault()
        let id = $(this).val()
        let post_id = $(this).data('post')
        $.ajax({
            method: 'get',
            url: "models/posts/getTagsByHeading.php",
            data: { heading_id: id, post_id: post_id },
            dataType: 'json',
            success: function (data) {
                printTags(data.allTags)
                compareCheckboxes(data)
            }
        })
    })

    const printTags = (data) => {
        let ispis = ''



        data.forEach(tag => {
            ispis += printTagByHeading(tag)
        })
        document.querySelector('#heading_tag').innerHTML = ispis
    }
    const printTagByHeading = (tag) => {

        return `
        <div class="col-6 col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="${tag.id}" id="tag${tag.id}" name="postTags"  ${tag == true && postTagsArr == true && postTagsArr.includes(tag.id) ? checked : ''}>
                <label class="form-check-label" for="tag${tag.id}">
                    ${tag.name}
                </label>
            </div>
        </div>
        `

    }
    const compareCheckboxes = (data) => {
        let tags = data.allTags
        let selectedTags = data.postTag
        let selectedTagsArr = []
        selectedTags.forEach(selectedTag => {
            selectedTagsArr.push(selectedTag.id)
        })

        tags.forEach(tag => {
            for (let i = 0; i < selectedTagsArr.length; i++) {
                if (selectedTagsArr[i] == tag.id) {
                    document.querySelector(`#tag${selectedTagsArr[i]}`).checked = true
                }
            }
        })
    }
    $(document).on('change', '#sortByDatePost', function (e) {
        e.preventDefault()
        filterPosts()
    })

    $(document).on('keyup', '#searchPosts', function (e) {
        e.preventDefault()
        filterPosts()
    })

    $(document).on('change', 'input[name="categories"]', function (e) {
        e.preventDefault()
        filterPosts()
    })

    $(document).on('change', 'input[name="headings"]', function (e) {
        e.preventDefault()
        filterPosts()
    })

    $(document).on('change', '#filterByDate', function (e) {
        e.preventDefault()
        let id = $(this).val()
        filterPosts()
    })
    $(document).on('click', '.post-pagination', function (e) {
        e.preventDefault()
        let limit = $(this).data('limit')
        filterPosts(limit)
    })
    const filterPosts = (page) => {
        filterPost(page)
    }

    const filterPost = (d) => {
        let text = document.querySelector("#searchPosts").value
        let kategorije = $('input[name="categories"]:checked')
        let headings = $('input[name="headings"]:checked')
        let order = document.querySelector('#filterByDate').value
        let selectedKategorije = []
        for (let kategorija of kategorije) {
            selectedKategorije.push(kategorija.value)
        }

        let selectedHeadings = []
        for (let heading of headings) {
            selectedHeadings.push(heading.value)
        }
        // console.log(d)
        $.ajax({
            method: 'get',
            url: 'models/posts/filter.php',
            data: {
                text: text,
                categories: selectedKategorije,
                headings: selectedHeadings,
                order: order,
                limit: d
            },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                printAllPost(data.posts, data.limit)
                printPagination(data.pages, '#postPagination', data.limit, 'post-pagination')
            },
            error: function (err) {
                console.log(err)
            }
        })
    }




    $(document).on('click', '.delete-user', function (e) {
        e.preventDefault()
        let id = $(this).data('id')
        $.ajax({
            method: 'post',
            url: 'models/users/delete.php',
            data: { id: id },
            dataType: 'json',
            success: function (data, statusTxt, xhr) {
                if (xhr.status == 204) {
                    getAllUsers()
                }
            },
            error: function (jqXHR, statusTxt, xhr) {
                printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#showUserErrorMessages', 'warning,danger')
            }
        })
    })
    $(document).on('click', '#btnSumbitUser', function (e) {
        e.preventDefault()
        userFormValidationAndRequest()
    })
    $(document).on('keyup', '#searchUser', function (e) {
        e.preventDefault()
        let text = $(this).val()
        filterUsers()
    })
    $(document).on('change', '#orderUserByDate', function (e) {
        e.preventDefault()
        filterUsers()
    })
    $(document).on('change', '#filterByRole', function (e) {
        e.preventDefault()
        filterUsers()
    })
    $(document).on('click', '.user-pagination', function (e) {
        e.preventDefault()
        let pagination = $(this).data('limit')
        filterUsers(pagination)
    })
    const filterUsers = pagination => {
        filterUser(pagination)
    }

    const filterUser = (d) => {
        let text = document.querySelector("#searchUser").value
        let orderUser = document.querySelector('#orderUserByDate').value
        let role = document.querySelector('#filterByRole').value

        // console.log(role);
        $.ajax({
            method: 'get',
            url: 'models/users/filter.php',
            data: {
                text: text,
                order: orderUser,
                role: role,
                limit: d
            },
            dataType: "json",
            success: function (data) {
                console.log(data)
                printAllUsers(data.res, data.limit)
                printPagination(data.pages, '#userPagination', data.limit, 'user-pagination')
            },
            error: function (err) {
                // console.log(err)
            }
        })
    }

    // category functions   
    const getAllCategories = () => {
        $.ajax({
            method: 'get',
            url: 'models/categories/getAll.php',
            dataType: 'json',
            success: function (data) {

                printAllCategories(data)
            },
            error: function (jqXHR, statusTxt, xhr) {
                printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#categoryResponseMessages', 'warning, danger')
            }
        })
    }
    const categoryFromRequestAndValidation = () => {
        const id = document.querySelector('#categoryId').value
        const name = document.querySelector("#categoryName").value
        if (id == "") {
            if (validationCategory().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/categories/insert.php',
                    data: { name: name },
                    dataType: 'json',
                    success: function (data, statsTxt, xhr) {
                        if (xhr.status == 201) {
                            window.location.href = 'admin.php?page=categories'
                        }
                    },
                    error: function (jqXHR, statusTxt, xhr) {
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#showDbResponseErrorMessages', 'warning,danger')
                    }
                })
            }
        } else {
            if (validationCategory().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/categories/update.php',
                    data: { name: name, id: id },
                    dataType: 'json',
                    success: function (data, statusTxt, xhr) {
                        if (xhr.status == 204) {
                            window.location.href = "admin.php?page=categories"
                        }
                    },
                    error: function (jqXHR, statusTxt, xhr) {
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#showDbResponseErrorMessages', 'warning,danger')
                    }
                })
            }
        }
    }
    const validationCategory = () => {
        const name = document.querySelector('#categoryName').value
        const reName = /^[A-Z][a-z]{3,15}$/
        const errors = []
        if (!reName.test(name)) {
            errors.push(name)
            createValidationErrorMessage('#categoryNameErrorMessage', 'text-danger', `Name of category isn't ok`)
        } else {
            removeValidationErrrorMessage('#categoryNameErrorMessage', 'text-danger')
        }

        return errors
    }

    const printAllCategories = (categories) => {
        let ispis = ' ', rb = 1
        if (categories.length > 0) {
            categories.forEach(category => {
                ispis += printCategory(category, rb)
                rb++
            })
        } else {
            ispis += NoContent("No category at this time", '6')
        }
        $('#categories').html(ispis)
    }

    const printCategory = (category, rb) => {
        prittierDateFormat(category.created_at)
        return `
            <tr>
                <th scope='row'>${rb++}</th>
                <td>${category.name}</td>
                <td>${prittierDateFormat(category.created_at)}</td>
                <td>${category.updated_at ? prittierDateFormat(category.updated_at) : '-'}</td>
                <td><a href="admin.php?page=action-categories&id=${category.id}" class="btn btn-sm btn-success">Update</a></td>
                <td><button type="button" class="btn btn-sm btn-danger delete-category" data-id="${category.id}">Delete</button></td>
            </tr>
        `
    }

    // headings 

    const getAllHeadings = () => {
        $.ajax({
            method: 'get',
            url: 'models/headings/getAll.php',
            dataType: 'json',
            success: function (data) {
                printAllHeadings(data.headings, data.limit)
            },
            error: function () { }
        })
    }
    const printAllHeadings = (headings, limit) => {
        let ispis = '', rb = 1
        console.log(limit)
        let lim = parseInt(limit)
        let redniBroj = (10 * lim) + 1
        if (headings.length > 0) {
            headings.forEach(heading => {
                ispis += printHeading(heading, redniBroj)
                redniBroj++
            })
        } else {
            ispis += NoContent('No headings at the moment', '7')
        }
        $('#headings').html(ispis)
    }
    const printHeading = (heading, rb) => {

        return `
            <tr>
                <th scope='row'>${rb}</th>
                <td>${heading.name}</td>
                <td>${heading.categoryName}</td>
                <td>${prittierDateFormat(heading.created_at)}</td>
                <td>${heading.updated_at ? prittierDateFormat(heading.updated_at) : '-'}</td>
                <td><a href="admin.php?page=heading_action&id=${heading.id}" class="btn btn-sm btn-success">Update</a></td>
                <td><button type="button" class="btn btn-sm btn-danger delete-heading" data-id="${heading.id}">Delete</button></td>
            </tr>
        `
    }
    const headingFromRequestAndValidation = () => {
        const id = document.querySelector('#headingId').value
        const name = document.querySelector('#headingName').value
        const categoryId = document.querySelector('#headingCategory').value
        if (id == "") {
            if (validationHeading().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/headings/insert.php',
                    data: { name: name, categoryId: categoryId },
                    dataType: 'json',
                    success: function (data, statusTxt, xhr) {
                        if (xhr.status == 201) {
                            window.location.href = 'admin.php?page=headings'
                        }
                    },
                    error: function (jqXHR, statusTxt, xhr) {
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#crudResponseErrorsMessages', 'warning,danger')
                    }
                })
            }
        } else {
            if (validationHeading().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/headings/update.php',
                    data: { name: name, categoryId: categoryId, id: id },
                    dataType: 'json',
                    success: function (data, statusTxt, xhr) {
                        if (xhr.status == 204) {
                            window.location.href = 'admin.php?page=headings'
                        }
                    },
                    error: function (jqXHR, statusTxt, xhr) {
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#crudResponseErrorsMessages', 'warning,danger')
                    }
                })
            }
        }
    }
    const validationHeading = () => {
        const name = document.querySelector('#headingName').value
        const categoryId = document.querySelector('#headingCategory').value
        console.log(categoryId)
        const reName = /^([A-Z]{1,}|[A-Z][a-z]{2,15})(\s[A-Z]{1,}|\s[A-Z][a-z]{2,15}|\s[a-z]{2,}|\s[\d]{0,2})*$/
        const errors = []
        if (!reName.test(name)) {
            errors.push(name)
            createValidationErrorMessage('#headingNameErrorMessage', 'text-danger', "Heading name isn't ok!")
        } else {
            removeValidationErrrorMessage('#headingNameErrorMessage', 'text-danger')
        }
        if (categoryId == 0) {
            errors.push(categoryId)
            createValidationErrorMessage('#headingCategoryErrorMessage', 'text-danger', "You must choose category");
        } else {
            removeValidationErrrorMessage('#headingCategoryErrorMessage', 'text-danger')
        }

        return errors
    }


    // tags
    const tagsFormValidationAndRequest = () => {
        const name = document.querySelector("#tagName").value
        const id = document.querySelector('#TagId').value
        const headings = $('input[name="tagHeadings"]:checked')
        const selectedHeadings = []
        for (let heading of headings) {
            selectedHeadings.push(heading.value)
        }
        console.log(id)
        if (id == "") {

            if (validationTags().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/tags/insert.php',
                    data: { name: name, headings: selectedHeadings },
                    success: function (data, statusTxt, xhr) {

                        if (xhr.status == 201) {
                            window.location.href = 'admin.php?page=tags'
                        }
                    },
                    error: function (jqXHR, statusTxt, xhr) {
                        console.log(jqXHR)
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#showDbTagsErrorMessages', 'warning,danger')
                    }
                })
            }
        } else {

            if (validationTags().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/tags/update.php',
                    data: { name: name, id: id, headings: selectedHeadings },
                    success: function (data, statusTxt, xhr) {
                        if (xhr.status == 204) {
                            window.location.href = 'admin.php?page=tags'
                        }
                    },
                    error: function (jqXHR, statusTxt, xhr) {
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#crudShowErrorMessages', 'warning,danger')
                    }
                })
            }
        }
    }
    const validationTags = () => {
        const name = document.querySelector('#tagName').value
        const headings = $('input[name="tagHeadings"]:checked')
        let selectedHeadings = []
        for (let heading of headings) {
            selectedHeadings.push(heading.value)
        }
        const reNameTag = /^([A-Z??????????]{1,}|[A-Z??????????][a-z??????????]{2,15}|[\w\d]{1,})([\.\:])?(\s[A-Z??????????]{1,}|\s[A-Z??????????][a-z??????????]{2,15}|\s[a-z??????????]{2,}|\s[\d]{1,}| \')*$/
        const errors = []
        if (!reNameTag.test(name)) {
            errors.push(name)
            createValidationErrorMessage('#tagNameErrorMessage', 'text-danger', "Tag name isn't ok")
        } else {
            removeValidationErrrorMessage('#tagNameErrorMessage', 'text-danger')
        }

        if (selectedHeadings.length == 0) {
            errors.push(selectedHeadings)
            createValidationErrorMessage('#tagHeading', 'text-danger', 'Must choose heading')
        } else {
            removeValidationErrrorMessage('#tagHeading', 'text-danger')
        }
        return errors
    }
    const getAllTags = () => {
        $.ajax({
            method: 'get',
            url: "models/tags/getAll.php",
            dataType: 'json',
            success: function (data) { printAllTags(data) },
            error: function (jqXHR, statusTxt, xhr) {
                printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#', 'danger,warning')
            }
        })
    }
    const printAllTags = (tags, limit) => {
        console.log(limit)
        let ispis = ''
        let rB = (parseInt(limit) * 10) + 1

        if (tags.length > 0) {
            tags.forEach(tag => {
                ispis += printTag(tag, rB)
                rB++
            })
        } else {
            ispis += NoContent("At the moment we don't have tags", '6')
        }
        $('#tags').html(ispis)
    }
    const printTag = (tag, rB) => {

        return `
            <tr>
                <th scope='row'>${rB}</th>
                <td>${tag.name}</td>
                <td>${prittierDateFormat(tag.created_at)}</td>
                <td>${tag.updated_at ? prittierDateFormat(tag.updated_at) : '-'}</td>
                <td><a href="admin.php?page=tag_action&id=${tag.id}" class="btn btn-sm btn-success">Update</a></td>
                <td><button type="button" class="btn btn-sm btn-danger delete-tag" data-id="${tag.id}">Delete</button></td>
            </tr>
        `
    }


    //users
    const getAllUsers = () => {
        $.ajax({
            method: 'get',
            url: 'models/users/getAll.php',
            dataType: 'json',
            success: function (data) {
                printAllUsers(data.users, data.limit)
                printPagination(data.pages, '#userPagination', data.limit, 'user-pagination')
            }
        })
    }
    const printAllUsers = (users, limit) => {

        ispis = '', rb = (parseInt(limit) * 10) + 1
        if (users.length > 0) {
            users.forEach(user => {
                ispis += printUser(user, rb)
                rb++
            })
        } else {
            ispis += NoContent('At this moment we dont have any user', '8')
        }
        $('#users').html(ispis)
    }
    const printUser = (user, rb) => {
        return `
            <tr>
                <th>${rb}</th>
                <td>${user.first_name + ' ' + user.last_name}</td>
                <td>${user.email}</td>
                <td>${user.roleName}</td>
                <td>${prittierDateFormat(user.created_at)}</td>
                <td>${user.updated_at ? prittierDateFormat(user.updated_at) : '-'}</td>
                <td><a href="admin.php?page=user_action&id=${user.id}" class="btn btn-success btn-sm">Update</a></td>
                <td><button type="button" class="btn btn-danger delete-user btn-sm" data-id="${user.id}">Delete</button></td>
            </tr>
        `
    }
    const getAllRoles = document.querySelectorAll('.roles')
    getAllRoles.forEach(role => {
        role.addEventListener('change', () => {
            let journalistRoles = document.querySelectorAll('.journalistRoles')
            if (role.value == 2) {
                journalistRoles.forEach(journalistRole => {
                    journalistRole.disabled = false
                })
            } else {
                journalistRoles.forEach(journalistRole => {
                    journalistRole.checked = false
                    journalistRole.disabled = true
                })
            }
        })
    })
    const userFormValidationAndRequest = () => {


        const id = document.querySelector('#userId').value
        const first_name = document.querySelector('#userFirstName').value
        const last_name = document.querySelector('#userLastName').value
        const email = document.querySelector('#userEmail').value

        const password = id == "" ? document.querySelector("#userPassword").value : ""
        const role = $('input[name="userRole"]:checked').val()

        const journalistRole = $('input[name="journalistRole"]:checked').val()

        if (id == "") {
            if (validationUserForm().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/users/insert.php',
                    data: {
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        password: password,
                        role: role,
                        journalistRole: journalistRole
                    },
                    success: function (data, statusTxt, xhr) {
                        if (xhr.status == 201) {
                            window.location.href = "admin.php?page=users"
                        }
                    }, error: function (jqXHR, statusTxt, xhr) {
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#crudUserErrorMessage', 'danger,warning')
                    }
                })
            }
        } else {
            if (validationUserForm().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/users/update.php',
                    data: {
                        id: id,
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        role_id: role,
                        journalistRole: journalistRole
                    },
                    success: function (data, statusTxt, xhr) {
                        if (xhr.status == 204) {
                            window.location.href = "admin.php?page=users"
                        }
                    }, error: function (jqXHR, statusTxt, xhr) {
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#crudUserErrorMessage', 'danger,warning')
                    }
                })
            }
        }
    }
    const validationUserForm = () => {


        const id = document.querySelector('#userId').value
        const first_name = document.querySelector('#userFirstName').value
        const last_name = document.querySelector('#userLastName').value
        const email = document.querySelector('#userEmail').value

        const password = id == "" ? document.querySelector("#userPassword").value : ""

        const role = $('input[name="userRole"]:checked').val()
        const journalistRole = $('input[name="journalistRole"]:checked').val()

        const reFirstLastName = /^[A-Z??????????][a-z??????????]{3,15}(\s[A-Z??????????][a-z??????????]{3,15})?$/
        const reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
        const rePassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/

        const errors = []

        if (!reFirstLastName.test(first_name)) {
            errors.push(first_name)
            createValidationErrorMessage('#userFirstNameErrorMessage', 'text-danger', "First name of user isn't ok")
        } else {
            removeValidationErrrorMessage('#userFirstNameErrorMessage', 'text-danger')
        }
        if (!reFirstLastName.test(last_name)) {
            errors.push(last_name)
            createValidationErrorMessage('#userLastNameErrorMessage', 'text-danger', "Last name of user isn't ok")
        } else {
            removeValidationErrrorMessage("#userLastNameErrorMessage", 'text-danger')
        }
        if (!reEmail.test(email)) {
            errors.push(email)
            createValidationErrorMessage('#userEmailErrorMessage', 'text-danger', "Your email isnt't ok")
        } else {
            removeValidationErrrorMessage('#userEmailErrorMessage', 'text-danger')
        }
        if (id == "") {
            if (!rePassword.test(password)) {
                errors.push(password)
                createValidationErrorMessage("#userPasswordErrorMessage", 'text-danger', "Your password isn't ok")
            } else {
                removeValidationErrrorMessage('#userPasswordErrorMessage', 'text-danger')
            }
        }

        if (!role) {
            errors.push(role)
            createValidationErrorMessage('#userRoleErrorMessage', 'text-danger', 'You must choose role')
        } else {
            removeValidationErrrorMessage('#userRoleErrorMessage', 'text-danger')
        }
        if (role == 2 && !journalistRole) {
            errors.push(journalistRole)
            createValidationErrorMessage('#journalistRoleError', 'text-danger', 'If u choose journalist,  u must choose category for journalist')
        } else {
            removeValidationErrrorMessage('#journalistRoleError', 'text-danger')
        }
        return errors
    }
    // posts

    const getAllPosts = () => {
        $.ajax({
            method: "get",
            url: 'models/posts/getAll.php',
            dataType: 'json',
            success: function (data) {
                printAllPost(data.posts, data.limit)
                printPagination(data.pages, '#postPagination', data.limit, '#post-pagination')
            },
            error: function (jqXHR, statusTxt, xhr) { }
        })
    }
    const printAllPost = (posts, limit) => {

        let ispis = ''
        let rb = (10 * limit) + 1

        if (posts.length > 0) {
            posts.forEach(post => {
                ispis += printPost(post, rb)
                rb++
            })
        } else {
            ispis += NoContent('At this time we dont have any posts', '8')
        }
        $('#posts').html(ispis)
    }
    const printPost = (post, rb) => {

        return `
            <tr>
                <th scope="row">${rb}</th>
                <td>${post.name}</td>
                <td>${post.categoryName}</td>
                <td>${post.headingName}</td>
                <td>${post.created_at}</td>
                <td>${post.updated_at ? post.updated_at : '/'}</td>
                <td><a href="admin.php?page=post_action&id=${post.id}" class="btn btn-sm btn-success">Update</a></td>
                <td><button type="button" class="btn btn-sm btn-danger" data-id="${post.id}">Delete</button></td>
                <td><a href="admin.php?page=post_details&id=${post.id}" class="btn btn-info btn-sm">Details</a></td>
                <td></td>
            </tr>
        `
    }
    const postFormVaildationAndRequest = () => {
        const id = document.querySelector("#postId").value
        const name = document.querySelector('#postName').value
        const postDesc = CKEDITOR.instances.postDescription.getData()
        const postImage = document.getElementById('postImage').files
        const postCategory = document.querySelector('#postCategory')?.value
        const postHeading = document.querySelector('#postHeading').value
        const tags = $('input[name="postTags"]:checked')
        const selectedTags = []
        for (let tag of tags) {
            selectedTags.push(tag.value)
        }


        let formData = new FormData()
        formData.append('name', name)
        formData.append('postDesc', postDesc)
        formData.append('category', postCategory)
        formData.append('heading', postHeading)
        formData.append('tags', selectedTags)
        if (id == "") {
            formData.append('image', $('#postImage')[0].files[0])
            if (postValidation().length == 0) {
                $.ajax({
                    method: 'post',
                    url: "models/posts/insert.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data, statusTxt, xhr) {

                        if (xhr.status == 201) {
                            window.location.href = "admin.php?page=posts"
                        }
                    },
                    error: function (jqXHR, statusTxt, xhr) {

                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#showDbPostsCrudMessages', 'warning,danger')
                    }
                })
            }
        } else {
            if (postImage.length != 0) {
                formData.append('image', $('#postImage')[0].files[0])
            }
            formData.append('id', id)
            if (postValidation().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/posts/update.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data, statusTxt, xhr) {

                        if (xhr.status == 204) {
                            window.location.href = "admin.php?page=posts"
                        }
                    }, error: function (jqXHR, statusTxt, xhr) {
                        printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#crudPostErrorMessages', 'warning,danger')
                    }
                })
            }
        }
    }
    const postValidation = () => {
        const id = document.querySelector("#postId").value
        const name = document.querySelector('#postName').value
        const postDesc = CKEDITOR.instances.postDescription.getData()
        const postImage = document.getElementById('postImage').files
        const postCategory = document.querySelector('#postCategory')?.value
        const postHeading = document.querySelector('#postHeading').value
        console.log(postHeading)
        const tags = $('input[name="postTags"]:checked')

        const selectedTags = []
        for (let tag of tags) {
            selectedTags.push(tag.value)
        }

        const errors = []
        if (name == '') {
            errors.push(name)
            createValidationErrorMessage('#postNameErrorMessage', 'text-danger', "Post name isn't ok!")
        } else {
            removeValidationErrrorMessage("#postNameErrorMessage", 'text-danger')
        }
        if (postDesc == '') {
            errors.push(postDesc)
            createValidationErrorMessage('#postDescErrorMessage', 'text-danger', "Description can't be empty")
        }
        else {
            removeValidationErrrorMessage('#postDescErrorMessage', 'text-danger')
        }
        if (id == "") {
            if (postImage.length == 0) {
                errors.push(postImage)
                createValidationErrorMessage('#postImageErrorMessage', 'text-danger', "You must choose image")
            } else {
                removeValidationErrrorMessage('#postImageErrorMessage', 'text-danger')
            }
        }
        if (postCategory !== undefined) {
            if (postCategory == 0) {
                errors.push(postCategory)
                createValidationErrorMessage('#postCategoryErrorMessage', 'text-danger', "You must choose category for the post!")
            } else {
                removeValidationErrrorMessage('#postCategoryErrorMessage', 'text-danger')
            }
        }
        if (postHeading == 0) {
            errors.push(postHeading)
            createValidationErrorMessage('#postHeadingErrorMessage', 'text-danger', 'You must choose heading for the post')
        } else {
            removeValidationErrrorMessage('#postHeadingErrorMessage', 'text-danger')
        }
        if (postHeading > 0) {
            if (selectedTags.length == 0) {
                errors.push(selectedTags)
                createValidationErrorMessage("#postTagsErrorMessage", 'text-danger', "You must choose at least one tag")
            } else {
                removeValidationErrrorMessage('#postTagsErrorMessage', 'text-danger')
            }
        }
        return errors
    }
    const printPostHeadings = (headings) => {

        let ispis = ''
        ispis += "<option value='0'>Choose</option>"
        if (headings.length > 1) {
            headings.forEach(heading => {
                ispis += `<option value ="${heading.id}">${heading.name}</option>`
            })
        }
        $('#postHeading').html(ispis)
    }


    $(document).on('click', '#submitTasks', function (e) {
        e.preventDefault()
        let id = document.querySelector('#taskId').value
        let text = CKEDITOR.instances.description.getData();
        let user = document.querySelector('#ddlUser').value
        console.log(text)
        if (id == '') {
            if (validationTasks().length == 0) {
                $.ajax({
                    method: "POST",
                    url: "models/tasks/insert.php",
                    data: {
                        description: text,
                        user: user
                    },
                    dataType: 'json',
                    success: function (data, status, xhr) {
                        if (xhr.status == 201) {
                            window.location.href = 'admin.php?page=tasks'
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }
                })
            }
        } else {
            if (validationTasks().length == 0) {
                $.ajax({
                    method: 'post',
                    url: 'models/tasks/update.php',
                    data: {
                        description: text,
                        user_id: user,
                        id: id
                    }, dataType: 'json',
                    success: function (data, statusTxt, xhr) {
                        if (xhr.status == 204) {
                            window.location.href = "admin.php?page=tasks"
                        }
                    }, error: function (err) {
                        console.log(err)
                    }
                })
            }
        }
    })
    const validationTasks = () => {
        let text = CKEDITOR.instances.description.getData();
        let user = document.querySelector('#ddlUser').value
        let errors = []
        if (text == '') {
            errors.push(text)
            createValidationErrorMessage('#validationErrorTaskDescription', 'text-danger', "Task description can't be empty")
        } else {
            removeValidationErrrorMessage('#validationErrorTaskDescription', 'text-danger')
        }
        if (user == 0) {
            errors.push(user)
            createValidationErrorMessage('#validationErrorTaskUser', 'text-danger', "You must choose user")
        } else {
            removeValidationErrrorMessage('#validationErrorTaskUser', 'text-danger')
        }

        return errors;
    }
    $(document).on('click', '.delete-task', function (e) {
        e.preventDefault()
        let id = $(this).data("id")
        $.ajax({
            method: 'POST',
            url: 'models/tasks/delete.php',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                console.log(data)
            }, error: function (err) {
                console.log(err)
            }
        })
    })

    const createValidationErrorMessage = (element, cls, text) => {
        const el = document.querySelector(element)
        el.classList.add(cls)
        el.textContent = text
    }
    const removeValidationErrrorMessage = (element, cls, text) => {
        const el = document.querySelector(element)
        el.textContent = ''
        el.classList.remove(cls)
    }
    const printResponseMessages = (statusCode, message, whereToPlace, colors) => {
        const color = colors.split(',')
        const colorYellow = color[0]
        const colorDanger = color[1]
        switch (statusCode) {
            case 404:
                printMessage(message, whereToPlace, colorDanger)
                break;
            case 409:
                printMessage(message, whereToPlace, colorYellow)
                break;
            case 422:
                printMessage(message, whereToPlace, colorDanger)
                break;
            case 500:
                printMessage(message, whereToPlace, colorDanger)
                break;

        }
    }
    const printMessage = (message, whereToPlace, color) => {

        let ispis = ''
        ispis += `
            <div class="alert alert-${color} alert-dismissible fade show fw-bold" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `
        $(whereToPlace).html(ispis)
    }

    const NoContent = (message, number, cls) => {
        return `
            <tr>
                <th scope="row" colspan="${number}">${message}</th>
            </tr>
        `
    }
    const printPagination = (numOfPages, whereToPlace, limit, cls) => {
        let ispis = ''
        let lim = 1

        if (numOfPages > 1) {
            if (limit) {
                lim += parseInt(limit)
            }
            for (let i = 0; i < numOfPages; i++) {


                ispis += ` <li class="page-item ${lim == (i + 1) ? 'active' : ''}"><a class="page-link ${cls}" href="#" data-limit="${i}">${i + 1}</a></li>`

            }
        }
        $(whereToPlace).html(ispis)
    }

    const prittierDateFormat = (datetime) => {
        const dateTime = datetime.split(' ')
        const time = dateTime[1]
        const date = dateTime[0].split('-')
        const finalDate = time + " " + date[2] + "/" + date[1] + "/" + date[0]
        return finalDate
    }
})