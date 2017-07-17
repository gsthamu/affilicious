import SearchResultItem from './search-results-item';

let SearchResults = Backbone.Collection.extend({
    model: SearchResultItem,

    /**
     * Initialize the search results.
     *
     * @since 0.9
     * @public
     */
    initialize() {
        this.on('sync', this.initImportListeners, this);
    },

    /**
     * Parse the Wordpress json Ajax response.
     *
     * @since 0.9
     * @param {Array} response
     * @returns {Array}
     * @public
     */
    parse: function(response) {
        return response && response.success ? response.data : [];
    },

    /**
     * Import the given item.
     *
     * @since 0.9
     * @param {Object} model
     * @public
     */
    importItem(model) {
        this.trigger('aff:amazon-import:search:results:import-item', model);
    },

    /**
     * Init the import listeners for all results items.
     *
     * @since 0.9
     * @public
     */
    initImportListeners() {
        this.forEach(this._initImportListener, this);
    },

    /**
     * Init the import listeners for the result item.
     *
     * @since 0.9
     * @private
     */
    _initImportListener(model) {
        model.on('aff:amazon-import:search:results:item:import', this.importItem, this);
    }
});

export default SearchResults;
