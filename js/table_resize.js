        var markerHTML = "XXX";
        var minWidth = 0;
        var dragingColumn = null;
        var startingX = 0;
        var currentX = 0;

        function getNewWidth () {
            var newWidth = minWidth;
            if (dragingColumn != null) {
                newWidth = parseInt (dragingColumn.parentNode.style.width);
                if (isNaN (newWidth)) {
                    newWidth = 0;
                }
                newWidth += currentX - startingX;
                if (newWidth < minWidth) {
                    newWidth = minWidth;
                }
            }
            return newWidth;
        }

        function columnMouseDown (event) {
            if (!event) {
                event = window.event;
            }
            if (dragingColumn != null) {
                ColumnGrabberMouseUp ();
            }
            startingX = event.clientX;
            currentX = startingX;
            dragingColumn = this;
            return true;
        }

        function columnMouseUp () {
            if (dragingColumn != null) {
                dragingColumn.parentNode.style.width = getNewWidth ();
                dragingColumn = null;
            }
			return true;
        }

        function columnMouseMove (event) {
            if (!event) {
                event = window.event;
            }
            if (dragingColumn != null) {
			    currentX = event.clientX;
                dragingColumn.parentNode.style.width = getNewWidth ();
                startingX = event.clientX;
                currentX = startingX;
			}
			return true;
        }

        function installTable (tableId) {
            var table = document.getElementById (tableId);
            // Test if there is such element in the document
            if (table != null) {
                // Test is this element a table
                if (table.nodeName.toUpperCase () == "TABLE") {
                    document.body.onmouseup = columnMouseUp;
                    document.body.onmousemove = columnMouseMove;
                    for (i = 0; i < table.childNodes.length; i++) {
                        var tableHead = table.childNodes[i];
                        // Look for the header
                        // Tables without header will not be handled.
                        if (tableHead.nodeName.toUpperCase () == "THEAD") {
                            // Go through THEAD nodes and set resize markers
                            // IE in THEAD contains TR element which contains TH elements
                            // Mozilla in THEAD contains TH elements
                            for (j = 0; j < tableHead.childNodes.length; j++) {
                                var tableHeadNode = tableHead.childNodes[j];
                                // Handles IE style THEAD with TR
                                if (tableHeadNode.nodeName.toUpperCase () == "TR") {
                                    for (k = 0; k < tableHeadNode.childNodes.length; k++) {
                                        var column = tableHeadNode.childNodes[k];
                                        var marker = document.createElement ("span");
                                        marker.innerHTML = markerHTML;
                                        marker.style.cursor = "move";
                                        marker.onmousedown = columnMouseDown;
                                        column.appendChild (marker);
                                        if (column.offsetWidth < minWidth) {
                                            column.style.width = minWidth;
                                        }
                                        else {
                                            column.style.width = column.offsetWidth;
                                        }
                                    }
                                }
                                // Handles Mozilla style THEAD
                                else if (tableHeadNode.nodeName.toUpperCase () == "TH") {
                                    var column = tableHeadNode;
                                    var marker = document.createElement ("span");
                                    marker.innerHTML = markerHTML;
                                    marker.style.cursor = "move";
                                    marker.onmousedown = columnMouseDown;
                                    column.appendChild (marker);
                                    if (column.offsetWidth < minWidth) {
                                        column.style.width = minWidth;
                                    }
                                    else {
                                        column.style.width = column.offsetWidth;
                                    }
                                }
                            }
                            table.style.tableLayout = "fixed";
                            // Once we have found THEAD element and updated it
                            // there is no need to go through rest of the table
                            i = table.childNodes.length;
                        }
                    }
                }
            }
        }
