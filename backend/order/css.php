<style>
    #tableList>thead>tr>th {
        background-color: #c1c8d7;
    }

    #tableList>thead>tr>th:nth-last-child(2),
    #tableList>tbody>tr>td:nth-last-child(2) {
        text-align: center;
    }

    #tableList>thead>tr>th:last-child,
    #tableList>tbody>tr>td:last-child {
        text-align: center;
    }

    .section-attach-file a:hover {
        color: #0056b3;
        text-decoration: underline !important;
    }

    .tbox{
        width: 100%;
        max-width: 100%;
        overflow: auto;
    }
    .tbox table.table thead tr>th{
        white-space: nowrap;
    }

    [block-event="true"] {
        position: relative;
    }

    [block-event="true"]::after {
        content: "กรุณาเลือกข้อมูลให้ครบก่อน";
        display: flex;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
        background-color: #f7f7f7fc;
        align-items: center;
        justify-content: center;
        font-size: 2.4rem;
        color: #888;
        letter-spacing: 1.5px;
        cursor: no-drop;
    }

</style>