const { __ } = wp.i18n;
const { useBlockProps, InspectorControls } = wp.blockEditor;
const {
  TextControl,
  PanelBody,
  PanelRow,
  BaseControl,
  CheckboxControl,
  RangeControl,
  ToggleControl,
  __experimentalRadio: Radio,
  __experimentalRadioGroup: RadioGroup,
} = wp.components;

import React, { useState, useEffect } from "react";
import { HeadingTagControl } from "../../../assets/src/js/partials/block-controls/blockControls";
import TermSelector from "./term-selector";
import {
  PanelInsertPost,
  PanelDisplayOptions,
  PanelFeedPosts,
  PanelGeneralOptions,
  PanelFeedOptions,
  PanelAdvancedFeedOptions,
} from "../../../assets/src/js/partials/block-panels/blockPanels";
import {
  FeedPostTypeControl,
  FeedTaxonomyControl,
  FeedCountControl,
  FeedTermControl,
  FeedOffsetControl,
  FeedUseAndLogicControl,
  FeedHostControl,
  FeedPanel,
  FeedPanelAdvanced,
} from "../../../assets/src/js/partials/block-controls/feed-controls/feed-controls";

const apiEndpoint = window.location.hostname.includes(".local")
  ? "http://wsuwp.local/wp-json/peopleapi/v1/people?"
  : "https://people.wsu.edu/wp-json/peopleapi/v1/people?"; // FIXME: Find a way to set via environment config


const queryAttributes = [
  "count",
  "page",
  "nid",
  "classification",
  "university_category",
  "university_location",
  "university_organization",
  "tag",
  "photo_size",
  "profile_order",
  "query_logic",
];

const filterOptions = [
  "classification",
  "organization",
  "location",
  "category",
  "tag",
  "search",
];

const displayOptions = [
  "photo",
  "name",
  "title",
  "office",
  "email",
  "degree",
  "focus-area",
  "address",
  "phone",
  "website",
];

export default function Edit(props) {
  const { attributes, setAttributes } = props;

  const [profiles, setProfiles] = useState([]);
  const [loading, setLoading] = useState(false);
  const debouncedAttributes = useValueDebounce(attributes, 1000);

  function handleCheckboxListChange(listKey, option, value) {
    let selectedItemList = attributes[listKey].slice();

    if (value) {
      if (selectedItemList.indexOf(option) === -1) {
        selectedItemList.push(option);
      }
    } else {
      selectedItemList = selectedItemList.filter((v) => v !== option);
    }

    setAttributes({ [listKey]: selectedItemList });
  }

  function getQueryAttributeSlugs(terms) {
    if (terms.length > 0) {
      return terms.map((t) => t.slug).join(",");
    }

    return "";
  }

  useEffect(
    () => {
      async function loadProfiles() {
        setLoading(true);

        // build url params based on attributes
        const params = queryAttributes
          .reduce(function (acc, curr, idx) {
            if (attributes[curr]) {
              const val = Array.isArray(attributes[curr])
                ? getQueryAttributeSlugs(attributes[curr])
                : attributes[curr];
              acc.push(curr.replace("_", "-") + "=" + val);
            }

            return acc;
          }, [])
          .join("&");

        // make request
        const response = await fetch(apiEndpoint + params);

        if (!response.ok) {
          setLoading(false);
          return;
        }

        // update state
        const profilesJson = await response.json();
        setProfiles(JSON.parse(profilesJson));
        setLoading(false);
      }

      loadProfiles();
    },
    queryAttributes.map((k) => debouncedAttributes[k])
  ); // only run on init and when query attributes are changed

  return (
    <div {...useBlockProps()}>
      <InspectorControls key="setting">
        <PanelDisplayOptions>
          <ToggleControl
            label="Hide Caption"
            checked={attributes.hideCaption}
            onChange={(hideCaption) => {
              setAttributes({ hideCaption });
            }}
          />
          <ToggleControl
            label="Hide Date"
            checked={attributes.hideDate}
            onChange={(hideDate) => {
              setAttributes({ hideDate });
            }}
          />
        </PanelDisplayOptions>
        <FeedPanel>
          {/* <FeedPostTypeControl
            label="Post type"
            help="Select post type to display"
            host={attributes.host || window.wsu.ROOT_URL}
            value={attributes.postType}
            onChange={(postType) => setAttributes({ postType })}
          /> */}
          <FeedTaxonomyControl
            label="Taxonomy"
            help="Select taxonomy to filter posts by"
            host={attributes.host || window.wsu.ROOT_URL}
            postType={attributes.postType}
            value={attributes.taxonomy}
            onChange={(taxonomy) => setAttributes({ taxonomy })}
          />
          {attributes.taxonomy && (
            <FeedTermControl
              label="Terms"
              help="Filter posts by searching and selecting terms in the selected taxonomy"
              host={attributes.host || window.wsu.ROOT_URL}
              taxonomy={attributes.taxonomy}
              value={attributes.termsSelected}
              onChange={ (terms) => setAttributes({ terms: terms.termsList, termsSelected: terms.termsSelected, queryTerms: terms.queryTerms } ) }
            />
          )}
          <FeedCountControl {...props} />
        </FeedPanel>
        <FeedPanelAdvanced>
          <FeedUseAndLogicControl {...props} />
          <FeedOffsetControl {...props} />
          <FeedHostControl {...props} />
        </FeedPanelAdvanced>
      </InspectorControls>

      <div className="wsu-gutenberg-video-list">
        {attributes.filters.length > 0 && (
          <div className="wsu-gutenberg-video-list__filters">
            {attributes.filters
              .filter((f) => f !== "search")
              .map((filter, index) => (
                <div
                  key={"filter-" + index}
                  className="wsu-gutenberg-video-list__filter"
                >
                  {attributes[filter + "_filter_label"] ||
                    "Filter by " + filter}
                  <span class="wsu-gutenberg-video-list__filter-icon dashicons dashicons-arrow-down-alt2"></span>
                </div>
              ))}

            {attributes.filters.includes("search") && (
              <div
                key="filter-search"
                className="wsu-gutenberg-video-list__filter"
              >
                {attributes["search_filter_label"]}
                <span class="wsu-gutenberg-video-list__filter-icon dashicons dashicons-search"></span>
              </div>
            )}
          </div>
        )}

        <div
          className={`wsu-gutenberg-video-list__profiles wsu-gutenberg-video-list__profiles--per-row-${attributes.columns}`}
        >
          {[...Array(attributes.columns)].map((e, i) => (
            <div className="wsu-gutenberg-video-list__profile">
              {attributes.display_fields.includes("title") && (
                <div className="wsu-gutenberg-video-list__video-image"></div>
              )}

              <div className="wsu-gutenberg-video-list__video-title">
                {attributes.display_fields.includes("name") && (
                  <h2 className="wsu-gutenberg-video-list__video-name">
                    Video Title
                  </h2>
                )}

                {attributes.display_fields.includes("title") && (
                  <div class="wsu-gutenberg-video-list__video-description">
                    Video Description
                  </div>
                )}
              </div>
            </div>
          ))}
        </div>


        
      </div>
    </div>
  );
}

// useDebounce Hook - https://usehooks.com/useDebounce/
function useValueDebounce(value, delay) {
  // State and setters for debounced value
  const [debouncedValue, setDebouncedValue] = useState(value);
  useEffect(
    () => {
      // Update debounced value after delay
      const handler = setTimeout(() => {
        setDebouncedValue(value);
      }, delay);
      // Cancel the timeout if value changes (also on delay change or unmount)
      // This is how we prevent debounced value from updating if value is changed ...
      // .. within the delay period. Timeout gets cleared and restarted.
      return () => {
        clearTimeout(handler);
      };
    },
    [value, delay] // Only re-call effect if value or delay changes
  );
  return debouncedValue;
}

