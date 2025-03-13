<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    

    <xsl:template match="/">
        <html>
        <head>
            <title>User List</title>
            <link rel="stylesheet" type="text/css" href="Views/users.css"/>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid #ccc;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f4f4f4;
                }
            </style>
        </head>
        <body>
            <h2>User List</h2>
            <table>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Password</th>
                </tr>
                <xsl:for-each select="users/user">
                    <tr>
                        <td><xsl:value-of select="userID"/></td>
                        <td><xsl:value-of select="username"/></td>
                        <td><xsl:value-of select="email"/></td>
                        <td><xsl:value-of select="dob"/></td>
                        <td><xsl:value-of select="password"/></td>
                    </tr>
                </xsl:for-each>
            </table>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
