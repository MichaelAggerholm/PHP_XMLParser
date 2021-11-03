<?xml version='1.0'?>
<xsl:stylesheet version="1.0"
      xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="xml" encoding="utf-8"/>
<xsl:template match="/">
    <xsl:variable name="root_path" select="/bookSupplier1" />
    <books>
        <xsl:for-each select="$root_path/books/book">
            <xsl:copy-of select="."/>
        </xsl:for-each>
    </books>
  </xsl:template>
</xsl:stylesheet>